<?php

declare(strict_types=1);

namespace Poke\Pokemon\Service;

use Magento\Framework\Serialize\SerializerInterface;
use Poke\Pokemon\Api\Data\PokeApiResponseInterface;
use Poke\Pokemon\Api\Data\PokeApiResponseInterfaceFactory;
use Poke\Pokemon\Config\PokeServiceConfigProvider;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;

class PokeApi
{
    /**
     * @param \Poke\Pokemon\Config\PokeServiceConfigProvider $pokeServiceConfigProvider
     * @param \GuzzleHttp\ClientFactory $clientFactory
     * @param \Poke\Pokemon\Api\Data\PokeApiResponseInterfaceFactory $pokeApiResponseInterfaceFactory
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(
        private readonly PokeServiceConfigProvider $pokeServiceConfigProvider,
        private readonly ClientFactory $clientFactory,
        private readonly PokeApiResponseInterfaceFactory $pokeApiResponseInterfaceFactory,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * Send a request to the Poke API
     *
     * @param string $path
     * @param string|int $identifier
     * @param string $method
     *
     * @return \Poke\Pokemon\Api\Data\PokeApiResponseInterface
     */
    public function sendRequest(string $path, string|int $identifier, string $method = 'GET'): PokeApiResponseInterface
    {
        $requestPath = sprintf('%s/%s', $path, $identifier);

        /** @var \GuzzleHttp\Client $client */
        $client = $this->clientFactory->create([
            'config' => [
                'base_uri' => $this->pokeServiceConfigProvider->getPokeApiPath(),
            ],
        ]);

        /** @var PokeApiResponseInterface $response */
        $response = $this->pokeApiResponseInterfaceFactory->create();
        try {
            $guzzleResponse = $client->request($method, $requestPath);

            $response
                ->setContent($this->serializer->unserialize($guzzleResponse->getBody()->getContents()))
                ->setStatus($guzzleResponse->getStatusCode());

        } catch (GuzzleException $e) {
            $response
                ->setError(true)
                ->setReason($e->getMessage())
                ->setStatus($e->getCode());
        }

        return $response;
    }
}

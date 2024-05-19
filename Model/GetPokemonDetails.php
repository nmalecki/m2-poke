<?php

declare(strict_types=1);

namespace Poke\Pokemon\Model;

use Magento\Framework\Webapi\Exception;
use Poke\Pokemon\Api\Data\PokemonDetailsInterface;
use Poke\Pokemon\Api\Data\PokemonDetailsInterfaceFactory;
use Poke\Pokemon\Api\GetPokemonDetailsInterface;
use Poke\Pokemon\Exception\PokemonApiResponseException;
use Poke\Pokemon\Exception\PokemonNotFoundException;
use Poke\Pokemon\Model\Cache\PokemonDetailsCache;
use Poke\Pokemon\Service\PokeApi;

class GetPokemonDetails implements GetPokemonDetailsInterface
{
    /**
     * @param \Poke\Pokemon\Service\PokeApi $pokeApi
     * @param \Poke\Pokemon\Api\Data\PokemonDetailsInterfaceFactory $pokemonDetailsInterfaceFactory
     * @param \Poke\Pokemon\Model\Cache\PokemonDetailsCache $pokemonDetailsCache
     */
    public function __construct(
        private readonly PokeApi $pokeApi,
        private readonly PokemonDetailsInterfaceFactory $pokemonDetailsInterfaceFactory,
        private readonly PokemonDetailsCache $pokemonDetailsCache
    ) {
    }

    /**
     * Get Pokemon Details object by a pokemon's name
     *
     * @param string $pokemonName
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     *
     * @throws \Poke\Pokemon\Exception\PokemonApiResponseException
     * @throws \Poke\Pokemon\Exception\PokemonNotFoundException
     */
    public function getPokemonByName(string $pokemonName): PokemonDetailsInterface
    {
        $pokemonName = strtolower($pokemonName);
        $cachedData = $this->pokemonDetailsCache->loadFromCache($pokemonName);
        if ($cachedData) {
            return $cachedData;
        }

        $response = $this->pokeApi->sendRequest('pokemon', $pokemonName);

        if ($response->getError()) {
            if ($response->getStatus() === Exception::HTTP_NOT_FOUND) {
                throw new PokemonNotFoundException(__('There is no Pokemon with name %1', $pokemonName));
            }

            throw new PokemonApiResponseException(
                __('Couldn\'t fetch pokemon details, original error: %1', $response->getReason())
            );
        }

        /** @var \Poke\Pokemon\Api\Data\PokemonDetailsInterface $pokemonDetails */
        $pokemonDetails = $this->pokemonDetailsInterfaceFactory->create();
        $content = $response->getContent();

        $pokemonDetails
            ->setName($content['name'] ?? '')
            ->setId($content['id'] ?? null)
            ->setFrontImageUrl($content['sprites']['front_default'] ?? '');

        $this->pokemonDetailsCache->saveToCache($pokemonDetails);

        return $pokemonDetails;
    }
}

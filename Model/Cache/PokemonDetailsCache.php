<?php

declare(strict_types=1);

namespace Poke\Pokemon\Model\Cache;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Poke\Pokemon\Api\Data\PokemonDetailsInterface;
use Poke\Pokemon\Api\Data\PokemonDetailsInterfaceFactory;
use Poke\Pokemon\Config\PokemonDetailsConfigProvider;

class PokemonDetailsCache
{
    public const POKEMON_DETAILS_CACHE_TAG = 'POKEMON_DETAILS';
    private const IDENTIFIER = 'pokemon_details';

    /**
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Poke\Pokemon\Api\Data\PokemonDetailsInterfaceFactory $pokemonDetailsFactory
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Poke\Pokemon\Config\PokemonDetailsConfigProvider $pokemonDetailsConfig
     */
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly PokemonDetailsInterfaceFactory $pokemonDetailsFactory,
        private readonly SerializerInterface $serializer,
        private readonly PokemonDetailsConfigProvider $pokemonDetailsConfig
    ) {
    }

    /**
     * Save Pokemon details to cache
     *
     * @param \Poke\Pokemon\Api\Data\PokemonDetailsInterface $pokemonDetails
     *
     * @return void
     */
    public function saveToCache(PokemonDetailsInterface $pokemonDetails): void
    {
        if (!$pokemonDetails->getName() || !$pokemonDetails->getId()) {
            return;
        }

        $data = $pokemonDetails->getData();
        $dataJson = $this->serializer->serialize($data);
        $cacheKey = $this->getCacheKey($pokemonDetails->getName());

        $this->cache->save(
            $dataJson,
            $cacheKey,
            [self::POKEMON_DETAILS_CACHE_TAG],
            $this->pokemonDetailsConfig->getPokemonDetailsCacheLifetime()
        );
    }

    /**
     * Load Pokemon details from cache
     *
     * @param string $pokemonName
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface|null
     */
    public function loadFromCache(string $pokemonName): ?PokemonDetailsInterface
    {
        $cacheKey = $this->getCacheKey($pokemonName);
        $dataJson = $this->cache->load($cacheKey);
        if (!$dataJson) {
            return null;
        }

        $data = $this->serializer->unserialize($dataJson);

        $pokemonDetails = $this->pokemonDetailsFactory->create();
        $pokemonDetails->setData($data);

        return $pokemonDetails;
    }

    /**
     * Return the cache key for the Pokemon details
     *
     * @param string $pokemonName
     *
     * @return string
     */
    public function getCacheKey(string $pokemonName): string
    {
        return md5(self::IDENTIFIER . $pokemonName);
    }
}

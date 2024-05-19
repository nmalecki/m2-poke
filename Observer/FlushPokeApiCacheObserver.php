<?php

declare(strict_types=1);

namespace Poke\Pokemon\Observer;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Poke\Pokemon\Config\PokeServiceConfigProvider;
use Poke\Pokemon\Model\Cache\PokemonDetailsCache;

class FlushPokeApiCacheObserver implements ObserverInterface
{
    /**
     * @param \Magento\Framework\App\CacheInterface $cache
     */
    public function __construct(
        private readonly CacheInterface $cache
    ) {
    }

    /**
     * Flush cached Poke API data if the API URL has changed
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $event = $observer->getEvent();
        $changedPaths = $event->getData('changed_paths');

        if (in_array(PokeServiceConfigProvider::XML_PATH_POKE_API_PATH, $changedPaths)) {
            $this->cache->clean([PokemonDetailsCache::POKEMON_DETAILS_CACHE_TAG]);
        }
    }
}

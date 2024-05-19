<?php

declare(strict_types=1);

namespace Poke\Pokemon\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class PokemonDetailsConfigProvider
{
    private const XML_PATH_DISPLAY_POKEMON_DETAILS = 'pokemon_details/details/enabled';
    private const XML_PATH_POKEMON_DETAILS_CACHE_LIFETIME = 'pokemon_details/details/cache_lifetime';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Determines whether the Pokemon details should be displayed on the storefront
     *
     * @return bool
     */
    public function isDisplayingPokemonDetailsEnabled(): bool
    {
        return (bool) $this->scopeConfig
            ->getValue(self::XML_PATH_DISPLAY_POKEMON_DETAILS, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return the cache lifetime for the Pokemon details
     *
     * @return int
     */
    public function getPokemonDetailsCacheLifetime(): int
    {
        return (int) $this->scopeConfig
            ->getValue(self::XML_PATH_POKEMON_DETAILS_CACHE_LIFETIME, ScopeInterface::SCOPE_STORE);
    }
}

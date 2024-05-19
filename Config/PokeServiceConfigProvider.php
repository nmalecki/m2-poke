<?php

declare(strict_types=1);

namespace Poke\Pokemon\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class PokeServiceConfigProvider
{
    public const XML_PATH_POKE_API_PATH = 'poke_api/general/api_url';
    private const DEFAULT_POKE_API_PATH = 'https://pokeapi.co/api/v2/';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Return the Poke API URL
     *
     * @return string
     */
    public function getPokeApiPath(): string
    {
        return (string) $this->scopeConfig->getValue(self::XML_PATH_POKE_API_PATH, ScopeInterface::SCOPE_STORE)
            ?: self::DEFAULT_POKE_API_PATH;
    }
}

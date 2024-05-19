<?php

declare(strict_types=1);

namespace Poke\Pokemon\Modifier;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Message\ManagerInterface;
use Poke\Pokemon\Api\GetPokemonDetailsInterface;
use Poke\Pokemon\Config\PokemonDetailsConfigProvider;
use Poke\Pokemon\Exception\PokemonApiResponseException;
use Poke\Pokemon\Exception\PokemonNotFoundException;
use Psr\Log\LoggerInterface;

class ProductPokemonApplier
{
    private const POKEMON_NAME_ATTRIBUTE = 'pokemon_name';

    /**
     * @param \Poke\Pokemon\Api\GetPokemonDetailsInterface $getPokemonDetails
     * @param \Poke\Pokemon\Config\PokemonDetailsConfigProvider $pokemonDetailsConfig
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        private readonly GetPokemonDetailsInterface $getPokemonDetails,
        private readonly PokemonDetailsConfigProvider $pokemonDetailsConfig,
        private readonly LoggerInterface $logger,
        private readonly ManagerInterface $messageManager
    ) {
    }

    /**
     * Append pokemon details to the product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return void
     * @throws \Poke\Pokemon\Exception\PokemonApiResponseException
     * @throws \Poke\Pokemon\Exception\PokemonNotFoundException
     */
    public function applyPokemonForProduct(ProductInterface $product): void
    {
        if (!$this->pokemonDetailsConfig->isDisplayingPokemonDetailsEnabled()) {
            return;
        }

        $pokemonName = $product->getCustomAttribute(self::POKEMON_NAME_ATTRIBUTE)?->getValue();

        if (!$pokemonName) {
            return;
        }

        $pokemon = $this->getPokemonDetails->getPokemonByName($pokemonName);

        $product->getExtensionAttributes()->setPokemon($pokemon);
    }

    /**
     * Append pokemon details to the product collection
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     *
     * @return void
     */
    public function applyPokemonForProductCollection(Collection $productCollection): void
    {
        if (!$this->pokemonDetailsConfig->isDisplayingPokemonDetailsEnabled()) {
            return;
        }

        $error = false;
        foreach ($productCollection as $product) {
            try {
                $this->applyPokemonForProduct($product);
            } catch (PokemonApiResponseException|PokemonNotFoundException $pokemonException) {
                $this->logger->error(
                    sprintf('Couldn\'t fetch pokemon details for product with SKU %s', $product->getSku()),
                    ['error' => $pokemonException->getMessage()]
                );
                $error = true;
            }
        }

        if ($error) {
            $this->messageManager->addErrorMessage(
                __('Couldn\'t fetch pokemon details for some products. Please contact with Customer Service.')
            );
        }
    }
}

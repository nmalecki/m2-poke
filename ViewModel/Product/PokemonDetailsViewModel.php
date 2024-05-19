<?php

declare(strict_types=1);

namespace Poke\Pokemon\ViewModel\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class PokemonDetailsViewModel implements ArgumentInterface
{
    /**
     * Return the Pokemon name for a product or the product name if the product does not have a Pokemon set
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return string|null
     */
    public function getProductName(ProductInterface $product): ?string
    {
        $pokemonName = $product->getExtensionAttributes()?->getPokemon()?->getName();

        return $pokemonName ?? $product->getName();
    }

    /**
     * Return the Pokemon image URL for a product and null if the product does not have a Pokemon set
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return string|null
     */
    public function getPokemonImageUrl(ProductInterface $product): ?string
    {
        return $product->getExtensionAttributes()?->getPokemon()?->getFrontImageUrl();
    }
}

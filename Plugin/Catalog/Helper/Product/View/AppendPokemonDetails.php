<?php

declare(strict_types=1);

namespace Poke\Pokemon\Plugin\Catalog\Helper\Product\View;

use Magento\Catalog\Helper\Product\View;
use Magento\Framework\View\Result\Page;
use Poke\Pokemon\Modifier\ProductPokemonApplier;

class AppendPokemonDetails
{
    /**
     * @param \Poke\Pokemon\Modifier\ProductPokemonApplier $productPokemonApplier
     */
    public function __construct(
        private readonly ProductPokemonApplier $productPokemonApplier
    ) {
    }

    /**
     * Append Pokemon details to the product on the PDP
     *
     * @param \Magento\Catalog\Helper\Product\View $subject
     * @param \Magento\Catalog\Helper\Product\View $result
     * @param \Magento\Framework\View\Result\Page $resultPage
     * @param \Magento\Catalog\Api\Data\ProductInterface|bool $product
     *
     * @return \Magento\Catalog\Helper\Product\View
     */
    public function afterInitProductLayout(View $subject, View $result, Page $resultPage, $product): View
    {
        if (!$product) {
            return $result;
        }

        $this->productPokemonApplier->applyPokemonForProduct($product);

        $pokemonName = $product->getExtensionAttributes()?->getPokemon()?->getName();
        if ($pokemonName) {
            $product->setName($pokemonName);
        }

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Poke\Pokemon\Plugin\Block\Product\ListProduct;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Poke\Pokemon\Modifier\ProductPokemonApplier;

class AppendPokemonDetailsToProducts
{
    /**
     * @param \Poke\Pokemon\Modifier\ProductPokemonApplier $productPokemonApplier
     */
    public function __construct(
        private readonly ProductPokemonApplier $productPokemonApplier
    ) {
    }

    /**
     * Append Pokemon details to the product collection on the PLP
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $result
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function afterGetLoadedProductCollection(ListProduct $subject, Collection $result): Collection
    {
        $this->productPokemonApplier->applyPokemonForProductCollection($result);

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Poke\Pokemon\Plugin\Catalog\Helper\Product\View;

use Magento\Catalog\Helper\Product\View;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Poke\Pokemon\Exception\PokemonApiResponseException;
use Poke\Pokemon\Exception\PokemonNotFoundException;
use Poke\Pokemon\Modifier\ProductPokemonApplier;
use Psr\Log\LoggerInterface;

class AppendPokemonDetails
{
    /**
     * @param \Poke\Pokemon\Modifier\ProductPokemonApplier $productPokemonApplier
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        private readonly ProductPokemonApplier $productPokemonApplier,
        private readonly ManagerInterface $messageManager,
        private readonly LoggerInterface $logger
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

        try {
            $this->productPokemonApplier->applyPokemonForProduct($product);

            $pokemonName = $product->getExtensionAttributes()?->getPokemon()?->getName();
            if ($pokemonName) {
                $product->setName($pokemonName);
            }

        } catch (PokemonApiResponseException $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage(
                __('An error occurred while fetching the Pokemon details. Please contact with Customer Service')
            );
        } catch (PokemonNotFoundException $notFoundException) {
            $this->logger->error(
                sprintf(
                    'There is no pokemon found for a product with id %s, original exception: %s',
                    $product->getId(),
                    $notFoundException->getMessage()
                )
            );
            $this->messageManager->addErrorMessage(
                __('The Pokemon for this product doesn\'t exist. Please contact with Customer Service')
            );
        }

        return $result;
    }
}

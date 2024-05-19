<?php

declare(strict_types=1);

namespace Poke\Pokemon\Model\Data;

use Magento\Framework\DataObject;
use Poke\Pokemon\Api\Data\PokemonDetailsInterface;

class PokemonDetails extends DataObject implements PokemonDetailsInterface
{
    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setName(?string $name): PokemonDetailsInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getData(self::ID) === null ? null : (int)$this->getData(self::ID);
    }

    /**
     * Setter for Id.
     *
     * @param int|null $id
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setId(?int $id): PokemonDetailsInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Getter for front image url.
     *
     * @return string
     */
    public function getFrontImageUrl(): string
    {
        return (string) $this->getData(self::FRONT_IMAGE_URL);
    }

    /**
     * Setter for front image url.
     *
     * @param string|null $frontImageUrl
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setFrontImageUrl(?string $frontImageUrl): PokemonDetailsInterface
    {
        return $this->setData(self::FRONT_IMAGE_URL, $frontImageUrl);
    }
}

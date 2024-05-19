<?php

declare(strict_types=1);

namespace Poke\Pokemon\Api\Data;

interface PokemonDetailsInterface
{
    /**
     * String constants for property names
     */
    public const NAME = 'name';
    public const ID = 'id';
    public const FRONT_IMAGE_URL = 'front_image_url';

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setName(?string $name): PokemonDetailsInterface;

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Setter for Id.
     *
     * @param int|null $id
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setId(?int $id): PokemonDetailsInterface;

    /**
     * Return front image URL
     *
     * @return string
     */
    public function getFrontImageUrl(): string;

    /**
     * Set front image URL
     *
     * @param string|null $frontImageUrl
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     */
    public function setFrontImageUrl(?string $frontImageUrl): PokemonDetailsInterface;
}

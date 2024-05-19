<?php

declare(strict_types=1);

namespace Poke\Pokemon\Api;

use Poke\Pokemon\Api\Data\PokemonDetailsInterface;

interface GetPokemonDetailsInterface
{
    /**
     * Get Pokemon Details object by a pokemon's name
     *
     * @param string $pokemonName
     *
     * @return \Poke\Pokemon\Api\Data\PokemonDetailsInterface
     *
     * @throws \Poke\Pokemon\Exception\PokemonApiResponseException
     * @throws \Poke\Pokemon\Exception\PokemonNotFoundException
     */
    public function getPokemonByName(string $pokemonName): PokemonDetailsInterface;
}

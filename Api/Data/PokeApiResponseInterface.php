<?php

declare(strict_types=1);

namespace Poke\Pokemon\Api\Data;

interface PokeApiResponseInterface
{
    /**
     * String constants for property names
     */
    public const STATUS = 'status';
    public const CONTENT = 'content';
    public const REASON = 'reason';
    public const ERROR = 'error';

    /**
     * Getter for Status.
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Setter for Status.
     *
     * @param int|null $status
     *
     * @return PokeApiResponseInterface
     */
    public function setStatus(?int $status): PokeApiResponseInterface;

    /**
     * Getter for Content.
     *
     * @return array
     */
    public function getContent(): array;

    /**
     * Setter for Content.
     *
     * @param array $content
     *
     * @return PokeApiResponseInterface
     */
    public function setContent(array $content): PokeApiResponseInterface;

    /**
     * Getter for Reason.
     *
     * @return string|null
     */
    public function getReason(): ?string;

    /**
     * Setter for Reason.
     *
     * @param string|null $reason
     *
     * @return PokeApiResponseInterface
     */
    public function setReason(?string $reason): PokeApiResponseInterface;

    /**
     * Getter for Error.
     *
     * @return bool|null
     */
    public function getError(): ?bool;

    /**
     * Setter for Error.
     *
     * @param bool|null $error
     *
     * @return PokeApiResponseInterface
     */
    public function setError(?bool $error): PokeApiResponseInterface;
}

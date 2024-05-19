<?php

declare(strict_types=1);

namespace Poke\Pokemon\Model\Data;

use Magento\Framework\DataObject;
use Poke\Pokemon\Api\Data\PokeApiResponseInterface;

class PokeApiResponse extends DataObject implements PokeApiResponseInterface
{
    /**
     * Getter for Status.
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS) === null ? null : (int)$this->getData(self::STATUS);
    }

    /**
     * Setter for Status.
     *
     * @param int|null $status
     *
     * @return \Poke\Pokemon\Api\Data\PokeApiResponseInterface
     */
    public function setStatus(?int $status): PokeApiResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Getter for Content.
     *
     * @return array
     */
    public function getContent(): array
    {
        return (array) $this->getData(self::CONTENT);
    }

    /**
     * Setter for Content.
     *
     * @param array $content
     *
     * @return \Poke\Pokemon\Api\Data\PokeApiResponseInterface
     */
    public function setContent(array $content): PokeApiResponseInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Getter for Reason.
     *
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->getData(self::REASON);
    }

    /**
     * Setter for Reason.
     *
     * @param string|null $reason
     *
     * @return \Poke\Pokemon\Api\Data\PokeApiResponseInterface
     */
    public function setReason(?string $reason): PokeApiResponseInterface
    {
        return $this->setData(self::REASON, $reason);
    }

    /**
     * Getter for Error.
     *
     * @return bool|null
     */
    public function getError(): ?bool
    {
        return $this->getData(self::ERROR) === null ? null : (bool)$this->getData(self::ERROR);
    }

    /**
     * Setter for Error.
     *
     * @param bool|null $error
     *
     * @return \Poke\Pokemon\Api\Data\PokeApiResponseInterface
     */
    public function setError(?bool $error): PokeApiResponseInterface
    {
        return $this->setData(self::ERROR, $error);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

class ProductType
{
    private $name = self::TYPE_BOOK;
    public const TYPE_BOOK = 'book';
    public const TYPE_REWARD = 'reward';
    public const TYPE_WALLET_REFILL = 'walletRefill';

    private const AVAILABLE_NAMES = [
        self::TYPE_BOOK,
        self::TYPE_REWARD,
        self::TYPE_WALLET_REFILL,
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNameIfIsCorrect(string $name): void
    {
        if (in_array($name, self::AVAILABLE_NAMES, true)) {
            $this->setName($name);
        }
    }

    public function isWalletRefill(): bool
    {
        return $this->getName() === self::TYPE_WALLET_REFILL;
    }

    /**
     * Factory method
     */
    public static function get(string $name): self
    {
        $productType = new self();
        $productType->setName($name);
        return $productType;
    }
}
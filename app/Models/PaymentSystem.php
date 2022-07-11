<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int|null $id
 * @property string|null $name
 * @property string|null $comment
 * @property bool|null $isSwitchedOn
 * @property string[]|null $availableCountryCodes
 * @property string[]|null $disableCountryCodes
 */
class PaymentSystem
{
    private $id;
    private $name;
    private $comment;
    private $isSwitchedOn;
    private $availableCountryCodes;
    private $disableCountryCodes;

    private const GOOGLE_PAY_ID = 5;
    private const APPLE_PAY_ID = 6;
    private const PAY_PAL_ID = 7;
    private const INSIDE_PAYMENT_SYSTEM = 8;
    private const EBANX_ID = 9;

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return (string)$this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getComment(): string
    {
        return (string)$this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function isSwitchedOn(): bool
    {
        return (bool)$this->isSwitchedOn;
    }

    public function setIsSwitchedOn(bool $isSwitchedOn): void
    {
        $this->isSwitchedOn = $isSwitchedOn;
    }

    public function getAvailableCountryCodes(): array
    {
        return (array)$this->availableCountryCodes;
    }

    public function setAvailableCountryCodes(array $availableCountryCodes): void
    {
        $this->availableCountryCodes = $availableCountryCodes;
    }

    public function getDisableCountryCodes(): array
    {
        return (array)$this->disableCountryCodes;
    }

    public function setDisableCountryCodes(array $disableCountryCodes): void
    {
        $this->disableCountryCodes = $disableCountryCodes;
    }

    public function isAvailableForCountry(UserCountry $userCountry): bool
    {
        if (in_array($userCountry->getCountryCode(), $this->getDisableCountryCodes(), true)) {
            return false;
        }

        if (
            empty($this->getAvailableCountryCodes())
            || in_array($userCountry->getCountryCode(), $this->getAvailableCountryCodes(), true)
        ) {
            return true;
        }

        return false;
    }

    public function isGooglePay(): bool
    {
        return $this->getId() === self::GOOGLE_PAY_ID;
    }

    public function isApplePay(): bool
    {
        return $this->getId() === self::APPLE_PAY_ID;
    }

    public function isPayPal(): bool
    {
        return $this->getId() === self::PAY_PAL_ID;
    }

    public function isInsidePayment(): bool
    {
        return $this->getId() === self::INSIDE_PAYMENT_SYSTEM;
    }

    public function isEbanx(): bool
    {
        return $this->getId() === self::EBANX_ID;
    }

    public function isEmpty(): bool
    {
        return $this->id === null;
    }
}

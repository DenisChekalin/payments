<?php

declare(strict_types=1);

namespace App\Models;

use App\Storage\Stubs\PaymentMethodStub;

/**
 * @property int|null $id
 * @property string|null $name
 * @property float|null $rent
 * @property PaymentSystem|null $paymentSystem
 * @property string|null $imageUrl
 * @property string|null $payUrl
 * @property bool|null isSwitchedOn
 * @property string[]|null $availableCountryCodes
 * @property string[]|null $disableCountryCodes
 * @property int|null $priority
 * @property bool|null $isCard
 */
class PaymentMethod
{
    private $id;
    private $name;
    private $rent;
    private $paymentSystem;
    private $imageUrl;
    private $payUrl;
    private $isSwitchedOn;
    private $availableCountryCodes;
    private $disableCountryCodes;
    private $priority;
    private $isCard;

    public const MINIMAL_AMOUNT_FOR_RUSSIAN_LANG_PAY_PAL = 30;
    public const MINIMAL_AMOUNT_FOR_RUSSIAN_REWARD_USING_INSIDE = 10;

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

    public function getRent(): float
    {
        return (float)$this->rent;
    }

    public function setRent(float $rent): void
    {
        $this->rent = $rent;
    }

    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem ?? new PaymentSystem();
    }

    public function setPaymentSystem(PaymentSystem $paymentSystem): void
    {
        $this->paymentSystem = $paymentSystem;
    }

    public function getImageUrl(): string
    {
        return (string)$this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getPayUrl(): string
    {
        return (string)$this->payUrl;
    }

    public function setPayUrl(string $payUrl): void
    {
        $this->payUrl = $payUrl;
    }

    public function isSwitchedOn(): bool
    {
        return $this->isSwitchedOn && $this->getPaymentSystem()->isSwitchedOn();
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

    public function getPriority(): int
    {
        return (int)$this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function isCard(): bool
    {
        return (bool)$this->isCard;
    }

    public function setIsCard(bool $isCard): void
    {
        $this->isCard = $isCard;
    }

    public static function query(): PaymentMethodStub
    {
        return new PaymentMethodStub();
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
            return $this->getPaymentSystem()->isAvailableForCountry($userCountry);
        }

        return false;
    }
}

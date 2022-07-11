<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property string $countryCode
 */
class UserCountry
{
    private string $countryCode = 'US';

    public const CODE_INDIA = 'IN';
    public const CODE_UKRAINE = 'UA';
    public const CODE_RUSSIA = 'RU';
    public const CODE_MEXICO = 'MX';
    public const CODE_PERU = 'PE';
    public const CODE_CHILE = 'CL';
    public const CODE_ECUADOR = 'EQ';
    public const CODE_VENEZUELA = 'VE';
    public const CODE_COLOMBIA = 'CO';
    public const CODE_BRAZIL = 'BR';
    public const CODE_ANTIGUA_AND_BARBUDA = 'AG';

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function isUkraine(): bool
    {
        return $this->countryCode === self::CODE_UKRAINE;
    }

    /**
     * Factory method
     */
    public static function get(string $countryCode): self
    {
        $userCountry = new self();
        $userCountry->setCountryCode($countryCode);
        return $userCountry;
    }
}
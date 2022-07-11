<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property string $type
 */
class UserOs
{
    private string $type = self::TYPE_ANDROID;

    public const TYPE_ANDROID = 'android';
    public const TYPE_WINDOWS = 'windows';
    public const TYPE_IOS = 'ios';

    private const AVAILABLE_TYPES = [
        self::TYPE_ANDROID,
        self::TYPE_WINDOWS,
        self::TYPE_IOS,
    ];

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setTypeIfCorrect(string $type): void
    {
        if (in_array($type, self::AVAILABLE_TYPES, true)) {
            $this->setType($type);
        }
    }

    public function isAndroid(): bool
    {
        return $this->getType() === self::TYPE_ANDROID;
    }

    public function isIos(): bool
    {
        return $this->getType() === self::TYPE_IOS;
    }

    public static function get(string $type): self
    {
        $userOs = new self();
        $userOs->setType($type);
        return $userOs;
    }
}
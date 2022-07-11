<?php

declare(strict_types=1);

namespace App\Models;

class Lang
{
    public const LANG_RU = 'ru';
    public const LANG_EN = 'en';
    public const LANG_ES = 'es';
    public const LANG_UK = 'uk';

    public const AVAILABLE_LANGS = [
        self::LANG_EN,
        self::LANG_ES,
        self::LANG_UK,
        self::LANG_RU,
    ];

    private string $code = self::LANG_EN;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function setCodeIfIsCorrect(string $code): void
    {
        if (in_array($code, self::AVAILABLE_LANGS)) {
            $this->setCode($code);
        }
    }

    public static function get(string $code): self
    {
        $lang = new self();
        $lang->setCode($code);
        return $lang;
    }
}
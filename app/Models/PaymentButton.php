<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property PaymentMethod $paymentMethod
 */
class PaymentButton
{
    private $paymentMethod;
    private $name;
    private $commission;
    private $imageUrl;
    private $payUrl;
    public const PRIVATBANK_BUTTON_NAME = 'Оплата картой ПриватБанка';
    public const PRIVATBANK_BUTTON_IMAGE = 'privatbank.jpg';

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        $this->name = $paymentMethod->getName();
        $this->commission = $paymentMethod->getRent();
        $this->imageUrl = $paymentMethod->getImageUrl();
        $this->payUrl = $paymentMethod->getPayUrl();
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getPayUrl(): string
    {
        return $this->payUrl;
    }
}
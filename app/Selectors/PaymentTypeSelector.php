<?php

declare(strict_types=1);

namespace App\Selectors;

use App\Models\Lang;
use App\Models\PaymentButton;
use App\Models\PaymentMethod;
use App\Models\ProductType;
use App\Models\UserCountry;
use App\Models\UserOs;

/**
 * @property ProductType $productType
 * @property float $amount
 * @property Lang $lang
 * @property UserCountry $countryCode
 * @property UserOs $userOs
 */
class PaymentTypeSelector
{
    private $productType;
    private $amount;
    private $lang;
    private $countryCode;
    private $userOs;

    public function __construct(ProductType $productType, float $amount, Lang $lang, UserCountry $countryCode, UserOs $userOs)
    {
        $this->productType = $productType;
        $this->amount = $amount;
        $this->lang = $lang;
        $this->countryCode = $countryCode;
        $this->userOs = $userOs;
    }

    public function getButtons(): array
    {
        $methods = PaymentMethod::query()
            ->filterByUserCountry($this->countryCode)
            ->filterBySwitchedOn()
            ->filterByOs($this->userOs)
            ->filterBySpecialCondition($this->productType, $this->amount, $this->lang, $this->countryCode, $this->userOs)
            ->getOrderedByPriorityDesc()
            ->get();

        $buttons = [];
        foreach ($methods as $method) {
            $buttons[] = new PaymentButton($method);
        }

        $buttons = $this->changeEbanxImage($buttons, $this->countryCode);

        if ($this->countryCode->isUkraine()) {
            $buttons = $this->addPrivatbankButton($buttons);
        }

        return $buttons;
    }

    private function addPrivatbankButton(array $buttons): array
    {
        /**
         * @var PaymentButton|null $firstCardButton
         * @var PaymentButton $button
         */
        $firstCardButton = null;
        foreach ($buttons as $button) {
            if ($button->getPaymentMethod()->isCard()) {
                $firstCardButton = clone $button;
                break;
            }
        }

        if ($firstCardButton) {
            $firstCardButton->setName(PaymentButton::PRIVATBANK_BUTTON_NAME);
            $firstCardButton->setImageUrl(PaymentButton::PRIVATBANK_BUTTON_IMAGE);
            array_unshift($buttons, $firstCardButton);
        }

        return $buttons;
    }

    private function changeEbanxImage(array $buttons, UserCountry $userCountry): array
    {
        /**
         * @var PaymentButton $button
         */
        $buttonImage = 'ebanx_card_' .  strtolower($userCountry->getCountryCode()) . '.jpg';
        foreach ($buttons as $button) {
            if (
                $button->getPaymentMethod()->isCard()
                && $button->getPaymentMethod()->getPaymentSystem()->isEbanx()
            ) {
                $button->setImageUrl($buttonImage);
            }
        }

        return $buttons;
    }

}
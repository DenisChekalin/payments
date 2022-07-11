<?php

declare(strict_types=1);

namespace App\Storage\Stubs;

use App\Models\UserCountry;
use App\Models\UserOs;
use App\Models\Lang;
use App\Models\PaymentMethod;
use App\Models\ProductType;

class PaymentMethodStub
{
    private array $paymentMethods = [];
    private array $paymentData = [
        [
            'id' => 1,
            'name' => 'Банковские карты',
            'rent' => 2.5,
            'system_id' => 1,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/123',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 100,
            'is_card' => true,
        ],
        [
            'id' => 2,
            'name' => 'LiqPay',
            'rent' => 2.0,
            'system_id' => 1,
            'image_url' => 'liq_pay.jpg',
            'pay_url' => '/pay/124',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => ['RU'],
            'priority' => 10,
            'is_card' => false,
        ],
        [
            'id' => 3,
            'name' => 'Терминалы IBOX',
            'rent' => 4.0,
            'system_id' => 1,
            'image_url' => 'ibox.jpg',
            'pay_url' => '/pay/125',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 4,
            'is_card' => false,
        ],
        [
            'id' => 4,
            'name' => 'Карты "МИР"',
            'rent' => 3.0,
            'system_id' => 2,
            'image_url' => 'card_mir.jpg',
            'pay_url' => '/pay/126',
            'switched_on' => true,
            'country_available' => ['RU', 'CN'],
            'country_disable' => [],
            'priority' => 55,
            'is_card' => true,
        ],
        [
            'id' => 5,
            'name' => 'Карты VISA / MasterCard',
            'rent' => 3.0,
            'system_id' => 2,
            'image_url' => 'cards.jpg',
            'pay_url' => '/pay/127',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => ['RU'],
            'priority' => 100,
            'is_card' => true,
        ],
        [
            'id' => 6,
            'name' => 'Яндекс.Кошелек',
            'rent' => 3.5,
            'system_id' => 2,
            'image_url' => 'yandex_wallet.jpg',
            'pay_url' => '/pay/128',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => ['RU'],
            'priority' => 1,
            'is_card' => false,
        ],
        [
            'id' => 7,
            'name' => 'QIWI-кошелек',
            'rent' => 3.2,
            'system_id' => 2,
            'image_url' => 'qiwi.jpg',
            'pay_url' => '/pay/129',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => ['RU'],
            'priority' => 2,
            'is_card' => false,
        ],
        [
            'id' => 8,
            'name' => 'Visa / MasterCard',
            'rent' => 1.0,
            'system_id' => 3,
            'image_url' => 'cards.jpg',
            'pay_url' => '/pay/130',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => ['RU'],
            'priority' => 105,
            'is_card' => true,
        ],
        [
            'id' => 9,
            'name' => 'LiqPay',
            'rent' => 2.1,
            'system_id' => 3,
            'image_url' => 'liq_pay.jpg',
            'pay_url' => '/pay/131',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 2,
            'is_card' => false,
        ],
        [
            'id' => 10,
            'name' => 'Method for switched off system',
            'rent' => 2.7,
            'system_id' => 4,
            'image_url' => 'image.jpg',
            'pay_url' => '/pay/132',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 1,
            'is_card' => false,
        ],
        [
            'id' => 11,
            'name' => 'Visa / MasterCard',
            'rent' => 2.0,
            'system_id' => 4,
            'image_url' => 'cards.jpg',
            'pay_url' => '/pay/134',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 1,
            'is_card' => true,
        ],
        [
            'id' => 12,
            'name' => 'Switched off method',
            'rent' => 2.7,
            'system_id' => 1,
            'image_url' => 'image.jpg',
            'pay_url' => '/pay/133',
            'switched_on' => false,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 1,
            'is_card' => true,
        ],
        [
            'id' => 13,
            'name' => 'Банковские карты',
            'rent' => 1.5,
            'system_id' => 5,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/135',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 100,
            'is_card' => true,
        ],
        [
            'id' => 14,
            'name' => 'Банковские карты',
            'rent' => 1.2,
            'system_id' => 6,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/136',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 100,
            'is_card' => true,
        ],
        [
            'id' => 15,
            'name' => 'Банковские карты',
            'rent' => 1.1,
            'system_id' => 7,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/137',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 100,
            'is_card' => true,
        ],
        [
            'id' => 16,
            'name' => 'Банковские карты',
            'rent' => 3.0,
            'system_id' => 8,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/138',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 95,
            'is_card' => true,
        ],
        [
            'id' => 17,
            'name' => 'Банковские карты EBANX',
            'rent' => 1.0,
            'system_id' => 9,
            'image_url' => 'bank_cards.jpg',
            'pay_url' => '/pay/139',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
            'priority' => 93,
            'is_card' => true,
        ],
    ];

    public function __construct()
    {
        foreach ($this->paymentData as $methodDataArray) {
            $paymentMethod = new PaymentMethod();
            $paymentMethod->setId($methodDataArray['id']);
            $paymentMethod->setName($methodDataArray['name']);
            $paymentMethod->setRent($methodDataArray['rent']);
            $paymentMethod->setPaymentSystem((new PaymentSystemStub())->getById($methodDataArray['system_id']));
            $paymentMethod->setImageUrl($methodDataArray['image_url']);
            $paymentMethod->setPayUrl($methodDataArray['pay_url']);
            $paymentMethod->setIsSwitchedOn($methodDataArray['switched_on']);
            $paymentMethod->setAvailableCountryCodes($methodDataArray['country_available']);
            $paymentMethod->setDisableCountryCodes($methodDataArray['country_disable']);
            $paymentMethod->setPriority($methodDataArray['priority']);
            $paymentMethod->setIsCard($methodDataArray['is_card']);
            $this->paymentMethods[] = $paymentMethod;
        }
    }

    public function get(): iterable
    {
        return $this->paymentMethods;
    }

    public function getOrderedByPriorityDesc(): self
    {
        usort($this->paymentMethods, static function(
            PaymentMethod $firstMethod,
            PaymentMethod $anotherMethod
        ) {
            return $firstMethod->getPriority() < $anotherMethod->getPriority() ? 1 : -1;
        });

        return $this;
    }

    public function filterByUserCountry(UserCountry $userCountry): self
    {
        $this->paymentMethods = array_filter(
            $this->paymentMethods,
            static function(PaymentMethod $paymentMethod) use ($userCountry) {
                return $paymentMethod->isAvailableForCountry($userCountry);
            }
        );

        return $this;
    }

    public function filterBySwitchedOn(): self
    {
        $this->paymentMethods = array_filter(
            $this->paymentMethods,
            static function(PaymentMethod $paymentMethod) {
                return $paymentMethod->isSwitchedOn()
                    && $paymentMethod->getPaymentSystem()->isSwitchedOn();
            },
            ARRAY_FILTER_USE_BOTH
        );

        return $this;
    }

    public function filterByOs(UserOs $userOs): self
    {
        if (!$userOs->isAndroid()) {
            $this->paymentMethods = array_filter(
                $this->paymentMethods,
                static function(PaymentMethod $paymentMethod) {
                    return !$paymentMethod->getPaymentSystem()->isGooglePay();
                }
            );
        }

        if (!$userOs->isIos()) {
            $this->paymentMethods = array_filter(
                $this->paymentMethods,
                static function(PaymentMethod $paymentMethod) {
                    return !$paymentMethod->getPaymentSystem()->isApplePay();
                }
            );
        }

        return $this;
    }

    public function filterBySpecialCondition(
        ProductType $productType,
        float $amount,
        Lang $lang,
        UserCountry $userCountry,
        UserOs $userOs
    ): self {
        if ($lang->getCode() === Lang::LANG_RU) {
            if ($amount < PaymentMethod::MINIMAL_AMOUNT_FOR_RUSSIAN_REWARD_USING_INSIDE) {
                $this->paymentMethods = array_filter(
                    $this->paymentMethods,
                    static function(PaymentMethod $paymentMethod) {
                        return $paymentMethod->getPaymentSystem()->isInsidePayment();
                    }
                );
            } elseif ($amount < PaymentMethod::MINIMAL_AMOUNT_FOR_RUSSIAN_LANG_PAY_PAL) {
                $this->paymentMethods = array_filter(
                    $this->paymentMethods,
                    static function(PaymentMethod $paymentMethod) {
                        return !$paymentMethod->getPaymentSystem()->isPayPal();
                    }
                );
            }
        }

        if ($productType->isWalletRefill()) {
            $this->paymentMethods = array_filter(
                $this->paymentMethods,
                static function(PaymentMethod $paymentMethod) {
                    return $paymentMethod->getPaymentSystem()->isInsidePayment();
                }
            );
        }

        return $this;
    }
}
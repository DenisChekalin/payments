<?php

declare(strict_types=1);

namespace App\Storage\Stubs;

use App\Models\PaymentSystem;
use App\Models\UserCountry;

class PaymentSystemStub
{
    private $paymentSystems = [];
    private $paymentData = [
        [
            'id' => 1,
            'name' => 'Interkassa',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 2,
            'name' => 'Yandex.Kassa',
            'comment' => '',
            'switched_on' => true,
            'country_available' => ['RU'],
            'country_disable' => [],
        ],
        [
            'id' => 3,
            'name' => 'CardPay',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 4,
            'name' => 'switched off payment system',
            'comment' => '',
            'switched_on' => false,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 5,
            'name' => 'Google Pay',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [UserCountry::CODE_INDIA],
        ],
        [
            'id' => 6,
            'name' => 'Apple Pay',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 7,
            'name' => 'PayPal',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 8,
            'name' => 'Inside payment system',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [],
            'country_disable' => [],
        ],
        [
            'id' => 9,
            'name' => 'EBANX',
            'comment' => '',
            'switched_on' => true,
            'country_available' => [
                UserCountry::CODE_MEXICO,
                UserCountry::CODE_PERU,
                UserCountry::CODE_CHILE,
                UserCountry::CODE_ECUADOR,
                UserCountry::CODE_VENEZUELA,
                UserCountry::CODE_COLOMBIA,
                UserCountry::CODE_BRAZIL,
                UserCountry::CODE_ANTIGUA_AND_BARBUDA,
            ],
            'country_disable' => [],
        ],
    ];

    public function __construct()
    {
        foreach ($this->paymentData as $dataArray) {
            $paymentSystem = new PaymentSystem();
            $paymentSystem->setId($dataArray['id']);
            $paymentSystem->setName($dataArray['name']);
            $paymentSystem->setComment($dataArray['comment']);
            $paymentSystem->setIsSwitchedOn($dataArray['switched_on']);
            $paymentSystem->setAvailableCountryCodes($dataArray['country_available']);
            $paymentSystem->setDisableCountryCodes($dataArray['country_disable']);
            $this->paymentSystems[] = $paymentSystem;
        }
    }

    public function get(): iterable
    {
        return $this->paymentSystems;
    }

    public function getById(int $id): PaymentSystem
    {
        $this->paymentSystems = array_filter(
            $this->paymentSystems,
            static function(PaymentSystem $paymentSystem) use ($id) {
                return $paymentSystem->getId() === $id;
            }
        );
        return array_shift($this->paymentSystems) ?? new PaymentSystem();
    }
}
<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Lang;
use App\Models\PaymentButton;
use App\Models\ProductType;
use App\Models\UserCountry;
use App\Models\UserOs;
use App\Selectors\PaymentTypeSelector;
use PHPUnit\Framework\TestCase;

/**
 * @property PaymentButton[][] $buttonsCollection
 */
class TestPaymentTypeSelector extends TestCase
{
    private array $buttonsCollection;
    private const LIQ_PAY_ID = 2;
    private const CARD_MIR_ID = 4;

    public function assertPreConditions(): void
    {
        $lang = Lang::get(Lang::LANG_EN);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userOs = UserOs::get(UserOs::TYPE_ANDROID);
        $userCountry = UserCountry::get(UserCountry::CODE_UKRAINE);

        $this->buttonsCollection[] = (new PaymentTypeSelector(
            $productType,
            45.0,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();

        $lang->setCode(Lang::LANG_UK);
        $this->buttonsCollection[] = (new PaymentTypeSelector(
            $productType,
            30.0,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();
    }

    public function testContainsType(): void
    {
        foreach ($this->buttonsCollection as $buttons) {
            $this->assertContainsOnly(PaymentButton::class, $buttons);
            $this->assertNotEmpty($buttons);
        }
    }

    public function testOrder(): void
    {
        foreach ($this->buttonsCollection as $buttons) {
            $buttonsCopy = $buttons;
            usort(
                $buttonsCopy,
                static function (PaymentButton $paymentButtonFirst, PaymentButton $paymentButtonSecond) {
                    return $paymentButtonSecond->getPaymentMethod()->getPriority() <=> $paymentButtonFirst->getPaymentMethod()->getPriority();
                }
            );
            $this->assertEquals($buttons, $buttonsCopy);
        }
    }

    public function testSwitchedOnMethods(): void
    {
        foreach ($this->buttonsCollection as $buttons) {
            $filteredButtons = array_filter($buttons, static function (PaymentButton $paymentButton) {
                return $paymentButton->getPaymentMethod()->isSwitchedOn();
            });
            $this->assertEquals($buttons, $filteredButtons);
        }
    }

    public function testFilterByCountry(): void
    {
        $userCountry = UserCountry::get(UserCountry::CODE_UKRAINE);

        foreach ($this->buttonsCollection as $buttons) {
            $filteredButtons = array_filter($buttons, static function (PaymentButton $paymentButton) use ($userCountry) {
                return $paymentButton->getPaymentMethod()->isAvailableForCountry($userCountry);
            });
            $this->assertEquals($buttons, $filteredButtons);
        }
    }

    public function testLiqPayDisabledForRussia(): void
    {
        $lang = Lang::get(Lang::LANG_RU);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userCountry = UserCountry::get(UserCountry::CODE_RUSSIA);
        $userOs = UserOs::get(UserOs::TYPE_ANDROID);

        $buttons = (new PaymentTypeSelector(
            $productType,
            42.0,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();
        $buttonsWithoutLiqPay = array_filter($buttons, static function (PaymentButton $paymentButton) {
            return $paymentButton->getPaymentMethod()->getId() !== self::LIQ_PAY_ID;
        });
        $this->assertEquals($buttons, $buttonsWithoutLiqPay);
    }

    public function testYandexKassaWorldCardForRussia(): void
    {
        $lang = Lang::get(Lang::LANG_RU);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userCountry = UserCountry::get(UserCountry::CODE_RUSSIA);
        $userOs = UserOs::get(UserOs::TYPE_WINDOWS);

        $buttons = (new PaymentTypeSelector(
            $productType,
            55.0,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();
        $buttonForCardMir = array_filter($buttons, static function (PaymentButton $paymentButton) {
            return $paymentButton->getPaymentMethod()->getId() === self::CARD_MIR_ID;
        });
        $this->assertNotEmpty($buttonForCardMir);
    }

    public function testPayPalForRussianLangWithSmallValue(): void
    {
        $lang = Lang::get(Lang::LANG_RU);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userCountry = UserCountry::get(UserCountry::CODE_RUSSIA);
        $userOs = UserOs::get(UserOs::TYPE_WINDOWS);

        $buttonsForSmallValue = (new PaymentTypeSelector(
            $productType,
            29.99,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();

        $buttonsForBigValue = (new PaymentTypeSelector(
            $productType,
            30.01,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();

        $buttonsForSmallValueWithoutPayPal = array_filter($buttonsForSmallValue, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isPayPal();
        });
        $this->assertEquals($buttonsForSmallValue, $buttonsForSmallValueWithoutPayPal);

        $buttonsForBigValueWithoutPayPal = array_filter($buttonsForBigValue, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isPayPal();
        });

        $this->assertNotEquals($buttonsForBigValue, $buttonsForBigValueWithoutPayPal);
    }

    public function testInsidePaymentForRussianLangRewardAndSmallValue(): void
    {
        $lang = Lang::get(Lang::LANG_RU);
        $productType = ProductType::get(ProductType::TYPE_REWARD);
        $userCountry = UserCountry::get(UserCountry::CODE_RUSSIA);
        $userOs = UserOs::get(UserOs::TYPE_WINDOWS);

        $buttonsForSmallValue = (new PaymentTypeSelector(
            $productType,
            9.99,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();

        $buttonsForBigValue = (new PaymentTypeSelector(
            $productType,
            10.01,
            $lang,
            $userCountry,
            $userOs
        ))->getButtons();

        $buttonsForSmallValueOnlyInsidePayment = array_filter($buttonsForSmallValue, static function (PaymentButton $button) {
            return $button->getPaymentMethod()->getPaymentSystem()->isInsidePayment();
        });
        $this->assertEquals($buttonsForSmallValue, $buttonsForSmallValueOnlyInsidePayment);

        $buttonsForBigValueOnlyInsidePayment = array_filter($buttonsForBigValue, static function (PaymentButton $button) {
            return $button->getPaymentMethod()->getPaymentSystem()->isInsidePayment();
        });

        $this->assertNotEquals($buttonsForBigValue, $buttonsForBigValueOnlyInsidePayment);

    }

    public function testGooglePay(): void
    {
        $lang = Lang::get(Lang::LANG_EN);
        $productType = ProductType::get(ProductType::TYPE_BOOK);

        $userCountry = UserCountry::get(UserCountry::CODE_UKRAINE);
        $userCountryIndia = UserCountry::get(UserCountry::CODE_INDIA);

        $userOsAndroid = UserOs::get(UserOs::TYPE_ANDROID);
        $userOsWindows = UserOs::get(UserOs::TYPE_WINDOWS);

        $buttonsForAndroid = (new PaymentTypeSelector(
            $productType,
            110.0,
            $lang,
            $userCountry,
            $userOsAndroid
        ))->getButtons();

        $buttonsForWindows = (new PaymentTypeSelector(
            $productType,
            110.0,
            $lang,
            $userCountry,
            $userOsWindows
        ))->getButtons();

        $buttonsForIndia = (new PaymentTypeSelector(
            $productType,
            110.0,
            $lang,
            $userCountryIndia,
            $userOsAndroid
        ))->getButtons();

        $buttonsForAndroidWithoutGooglePay = array_filter($buttonsForAndroid, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isGooglePay();
        });
        $this->assertNotEquals($buttonsForAndroid, $buttonsForAndroidWithoutGooglePay);

        $buttonsForWindowsWithoutGooglePay = array_filter($buttonsForWindows, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isGooglePay();
        });
        $this->assertEquals($buttonsForWindows, $buttonsForWindowsWithoutGooglePay);

        $buttonsForIndiaWithoutGooglePay = array_filter($buttonsForIndia, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isGooglePay();
        });
        $this->assertEquals($buttonsForIndia, $buttonsForIndiaWithoutGooglePay);
    }

    public function testApplePay(): void
    {
        $lang = Lang::get(Lang::LANG_EN);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userCountry = UserCountry::get(UserCountry::CODE_UKRAINE);

        $userIos = UserOs::get(UserOs::TYPE_IOS);
        $userOsWindows = UserOs::get(UserOs::TYPE_WINDOWS);

        $buttonsForIos = (new PaymentTypeSelector(
            $productType,
            110.0,
            $lang,
            $userCountry,
            $userIos
        ))->getButtons();

        $buttonsForWindows = (new PaymentTypeSelector(
            $productType,
            110.0,
            $lang,
            $userCountry,
            $userOsWindows
        ))->getButtons();

        $buttonsForIosWithoutApplePay = array_filter($buttonsForIos, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isApplePay();
        });
        $this->assertNotEquals($buttonsForIos, $buttonsForIosWithoutApplePay);

        $buttonsForWindowsWithoutApplePay = array_filter($buttonsForWindows, static function (PaymentButton $button) {
            return !$button->getPaymentMethod()->getPaymentSystem()->isApplePay();
        });
        $this->assertEquals($buttonsForWindows, $buttonsForWindowsWithoutApplePay);
    }

    public function testUkraineAddPrivatbankButton(): void
    {
        foreach ($this->buttonsCollection as $buttons) {
            $this->assertNotEmpty($buttons[0]);
            $this->assertEquals($buttons[0]->getName(), PaymentButton::PRIVATBANK_BUTTON_NAME);
            $this->assertEquals($buttons[0]->getImageUrl(), PaymentButton::PRIVATBANK_BUTTON_IMAGE);
        }
    }

    public function testWalletRefill(): void
    {
        $lang = Lang::get(Lang::LANG_EN);
        $productType = ProductType::get(ProductType::TYPE_WALLET_REFILL);
        $userCountry = UserCountry::get(UserCountry::CODE_UKRAINE);
        $userIos = UserOs::get(UserOs::TYPE_IOS);

        $buttons = (new PaymentTypeSelector(
            $productType,
            100.0,
            $lang,
            $userCountry,
            $userIos
        ))->getButtons();

        $buttonsOnlyInsidePayment = array_filter($buttons, static function (PaymentButton $button) {
            return $button->getPaymentMethod()->getPaymentSystem()->isInsidePayment();
        });
        $this->assertEquals($buttons, $buttonsOnlyInsidePayment);
    }

    public function testEbanxButtonPicture(): void
    {
        $lang = Lang::get(Lang::LANG_EN);
        $productType = ProductType::get(ProductType::TYPE_BOOK);
        $userIos = UserOs::get(UserOs::TYPE_WINDOWS);
        $countries = [
            UserCountry::CODE_MEXICO,
            UserCountry::CODE_PERU,
            UserCountry::CODE_CHILE,
            UserCountry::CODE_ECUADOR,
            UserCountry::CODE_VENEZUELA,
            UserCountry::CODE_COLOMBIA,
            UserCountry::CODE_BRAZIL,
            UserCountry::CODE_ANTIGUA_AND_BARBUDA,
        ];

        foreach ($countries as $countryCode) {
            $userCountry = UserCountry::get($countryCode);
            $buttons = (new PaymentTypeSelector(
                $productType,
                100.0,
                $lang,
                $userCountry,
                $userIos
            ))->getButtons();

            $buttonsEbanxCards = array_filter($buttons, static function (PaymentButton $button) {
               return $button->getPaymentMethod()->isCard()
                    && $button->getPaymentMethod()->getPaymentSystem()->isEbanx();
            });

            $buttonImage = 'ebanx_card_' .  strtolower($countryCode) . '.jpg';
            /**
             * @var PaymentButton $button
             */
            foreach ($buttonsEbanxCards as $button) {
                $this->assertEquals(
                    $buttonImage,
                    $button->getImageUrl(),
                    "Not correct image for ebanx. Country {$countryCode}, button #{$button->getName()}"
                );
            }
        }
    }
}

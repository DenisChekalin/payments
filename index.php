<?php
require 'vendor/autoload.php';

use App\Models\Lang;
use App\Models\PaymentButton;
use App\Models\ProductType;
use App\Models\UserCountry;
use App\Models\UserOs;
use App\Selectors\PaymentTypeSelector;

//http://localhost/index.php?productType=book&amount=45.67&lang=ru&countryCode=UA&userOs=android
$productType = new ProductType();
$productType->setNameIfIsCorrect((string)($_GET['productType'] ?? ProductType::TYPE_BOOK));

$amount = (float)($_GET['amount'] ?? 0.0);

$lang = new Lang();
$lang->setCodeIfIsCorrect(strtolower((string)($_GET['lang'] ?? Lang::LANG_EN)));

$userCountry = UserCountry::get($_GET['countryCode'] ?? UserCountry::CODE_UKRAINE);

$userOs = new UserOs();
$userOs->setTypeIfCorrect($_GET['android'] ?? UserOs::TYPE_ANDROID);

$paymentTypeSelector = new PaymentTypeSelector($productType, $amount, $lang, $userCountry, $userOs);
$paymentButtons = $paymentTypeSelector->getButtons();

/**
 * @var PaymentButton $button
 */
foreach ($paymentButtons as $button) {
    echo 'Name: ', $button->getName(), '<br>';
    echo 'Rent: ', $button->getCommission(), '<br>';
    echo 'Image: ', $button->getImageUrl(), '<br>';
    echo 'Payment URL: ', $button->getPayUrl(), '<br><br>';
}
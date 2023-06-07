<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;
use intec\template\Properties;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('intec.core'))
    return;

$bBase = false;
$bLite = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale')) {
    $bBase = true;
} else if (Loader::includeModule('intec.startshop')) {
    $bLite = true;
}

$arParams = ArrayHelper::merge([
    'SETTINGS_USE' => 'N',
    'LAZYLOAD_USE' => 'N',
    'BORDERS' => 'Y',
    'COLUMNS' => 3,
    'POSITION' => 'left',
    'SIZE' => 'big',
    'WIDE' => 'Y',
    'SLIDER_USE' => 'N',
    'SLIDER_NAVIGATION' => 'N',
    'SLIDER_LOOP' => 'N',
    'SLIDER_AUTO_PLAY_USE' => 'N',
    'SLIDER_AUTO_PLAY_TIME' => 1000,
    'SLIDER_AUTO_PLAY_SPEED' => 500,
    'SLIDER_AUTO_PLAY_HOVER_PAUSE' => 'N'
], $arParams);

if ($arParams['SETTINGS_USE'] === 'Y')
    include (__DIR__ . '/modifiers/settings.php');

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arVisual = [
    'LAZYLOAD' => [
        'USE' => !defined('EDITOR') && $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => !defined('EDITOR') && $arParams['LAZYLOAD_USE'] === 'Y' ? Properties::get('template-images-lazyload-stub') : null
    ],
    'BORDERS' => $arParams['BORDERS'] === 'Y',
    'COLUMNS' => ArrayHelper::fromRange([3, 2, 4], $arParams['COLUMNS']),
    'POSITION' => ArrayHelper::fromRange(['left', 'center', 'right'], $arParams['POSITION']),
    'SIZE' => ArrayHelper::fromRange(['small', 'big'], $arParams['SIZE']),
    'WIDE' => $arParams['WIDE'] === 'Y',
    'SLIDER' => [
        'USE' => $arParams['SLIDER_USE'] === 'Y',
        'NAVIGATION' => $arParams['SLIDER_NAVIGATION'] === 'Y',
        'LOOP' => $arParams['SLIDER_LOOP'] === 'Y',
        'AUTO' => [
            'USE' => $arParams['SLIDER_AUTO_PLAY_USE'] === 'Y',
            'TIME' => Type::toInteger($arParams['SLIDER_AUTO_PLAY_TIME']),
            'SPEED' => Type::toInteger($arParams['SLIDER_AUTO_PLAY_SPEED']),
            'PAUSE' => $arParams['SLIDER_AUTO_PLAY_HOVER_PAUSE'] === 'Y'
        ]
    ]
];

if ($arVisual['SLIDER']['AUTO']['TIME'] < 100)
    $arVisual['SLIDER']['AUTO']['TIME'] = 100;

if ($arVisual['SLIDER']['AUTO']['SPEED'] < 100)
    $arVisual['SLIDER']['AUTO']['SPEED'] = 100;


$arResult['URL'] = [
    'BASKET' => ArrayHelper::getValue($arParams, 'BASKET_URL')
];

foreach ($arResult['URL'] as $sKey => $sUrl)
    $arResult['URL'][$sKey] = StringHelper::replaceMacros($sUrl, $arMacros);

unset($sKey, $sUrl);

if ($bLite)
    include(__DIR__.'/modifiers/lite/catalog.php');

$arResult['ACTION'] = 'none';

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DATA'] = [
        'OFFER' => !empty($arItem['OFFERS']),
        'ACTION' => $arResult['ACTION'],
        'PRICE' => [
            'SHOW' => true
        ]
    ];

    $arData = &$arItem['DATA'];

    if (!empty($arParams['PROPERTY_REQUEST_USE'])) {
        if (!empty(ArrayHelper::getValue($arItem['PROPERTIES'], [
            $arParams['PROPERTY_REQUEST_USE'],
            'VALUE'
        ])))
            $arData['ACTION'] = 'request';
    }

    if ($arData['ACTION'] === 'request') {
        $arData['PRICE']['SHOW'] = false;
    }
}

include(__DIR__.'/modifiers/pictures.php');

if ($bBase)
    include(__DIR__.'/modifiers/base/catalog.php');

if ($bBase || $bLite)
    include(__DIR__.'/modifiers/catalog.php');

$arResult['VISUAL'] = $arVisual;

unset($bBase, $bLite, $arMacros, $arVisual);
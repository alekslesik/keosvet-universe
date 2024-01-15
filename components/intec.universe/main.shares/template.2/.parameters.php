<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$arTemplateParameters = [];

if (empty($arCurrentValues['IBLOCK_ID']))
    return;

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SETTINGS_USE'] !== 'Y') {
    $arTemplateParameters['LAZYLOAD_USE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_LAZYLOAD_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

$arProperties = Arrays::fromDBResult(CIBlockProperty::GetList(['SORT' => 'ASC'], [
    'ACTIVE' => 'Y',
    'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID']
]))->indexBy('CODE');

$hPropertyTextSingle = function ($key, $value) {
    if ($value['PROPERTY_TYPE'] == 'S' && $value['LIST_TYPE'] === 'L' && $value['MULTIPLE'] === 'N')
        return [
            'key' => $key,
            'value' => '['.$key.'] '.$value['NAME']
        ];

    return ['skip' => true];
};
$hPropertyDate = function ($key, $value) {
    if (
        $value['PROPERTY_TYPE'] === 'S' &&
        $value['LIST_TYPE'] === 'L' &&
        $value['MULTIPLE'] === 'N' && (
            $value['USER_TYPE'] === 'Date' ||
            $value['USER_TYPE'] === 'DateTime'
        )
    )
        return [
            'key' => $key,
            'value' => '['.$key.'] '.$value['NAME']
        ];

    return ['skip' => true];
};

$arPropertyTextSingle = $arProperties->asArray($hPropertyTextSingle);
$arPropertyDate = $arProperties->asArray($hPropertyDate);

$arTemplateParameters['ELEMENT_HEADER_PROPERTY_TEXT'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_ELEMENT_HEADER_PROPERTY_TEXT'),
    'TYPE' => 'LIST',
    'VALUES' => $arPropertyTextSingle,
    'ADDITIONAL_VALUES' => 'Y',
    'REFRESH' => 'Y'
];
$arTemplateParameters['COLUMNS'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_COLUMNS'),
    'TYPE' => 'LIST',
    'VALUES' => [
        1 => '1',
        2 => '2'
    ],
    'DEFAULT' => 2
];
$arTemplateParameters['LINK_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_LINK_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['LINK_USE'] === 'Y') {
    $arTemplateParameters['LINK_BLANK'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_LINK_BLANK'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

if (!empty($arCurrentValues['ELEMENT_HEADER_PROPERTY_TEXT'])) {
    $arTemplateParameters['ELEMENT_HEADER_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_ELEMENT_HEADER_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y'
    ];
}

$arTemplateParameters['PREVIEW_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_PREVIEW_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['PREVIEW_SHOW'] === 'Y') {
    $arTemplateParameters['PREVIEW_TRUNCATE_USE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_PREVIEW_TRUNCATE_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['PREVIEW_TRUNCATE_USE'] === 'Y') {
        $arTemplateParameters['PREVIEW_TRUNCATE_WORDS'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_SHARES_TEMP2_PREVIEW_TRUNCATE_WORDS'),
            'TYPE' => 'STRING',
            'DEFAULT' => 40
        ];
    }
}

$arTemplateParameters['LINK_ALL_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_LINK_ALL_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['LINK_ALL_SHOW'] == 'Y') {
    $arTemplateParameters['LINK_ALL_TEXT'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_LINK_ALL_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_SHARES_TEMP2_LINK_ALL_TEXT_DEFAULT')
    ];
}

$arTemplateParameters['TIMER_SHOW'] = [
    'PARENT' => 'TIMER',
    'NAME' => Loc::getMessage('C_SHARES_TEMP2_TIMER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['TIMER_SHOW'] === 'Y') {
    $arTemplateParameters['TIMER_PROPERTY_UNTIL_DATE'] = [
        'PARENT' => 'TIMER',
        'NAME' => Loc::getMessage('C_SHARES_TEMP2_TIMER_PROPERTY_UNTIL_DATE'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyDate,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];

    if (!empty($arCurrentValues['TIMER_PROPERTY_UNTIL_DATE'])) {
        $arTemplateParameters['TIMER_PROPERTY_DISCOUNT'] = [
            'PARENT' => 'TIMER',
            'NAME' => Loc::getMessage('C_SHARES_TEMP2_TIMER_PROPERTY_DISCOUNT'),
            'TYPE' => 'LIST',
            'VALUES' => $arPropertyTextSingle,
            'ADDITIONAL_VALUES' => 'Y',
            'REFRESH' => 'Y'
        ];

        include(__DIR__ . '/parameters/timer.php');
    }
}
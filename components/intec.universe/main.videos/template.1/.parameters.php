<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];

if ($arCurrentValues['SETTINGS_USE'] !== 'Y') {
    $arTemplateParameters['LAZYLOAD_USE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_LAZYLOAD_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

$arTemplateParameters['COLUMNS'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_COLUMNS'),
    'TYPE' => 'LIST',
    'VALUES' => [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5
    ],
    'DEFAULT' => 3
];
$arTemplateParameters['NAME_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_NAME_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['SLIDER_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SLIDER_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SLIDER_USE'] === 'Y') {
    $arTemplateParameters['SLIDER_AUTO_PLAY_USE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SLIDER_AUTO_PLAY_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['SLIDER_AUTO_PLAY_USE'] === 'Y') {
        $arTemplateParameters['SLIDER_AUTO_PLAY_TIME'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SLIDER_AUTO_PLAY_TIME'),
            'TYPE' => 'STRING',
            'DEFAULT' => 10000
        ];
        $arTemplateParameters['SLIDER_AUTO_PLAY_SPEED'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SLIDER_AUTO_PLAY_SPEED'),
            'TYPE' => 'STRING',
            'DEFAULT' => 500
        ];
        $arTemplateParameters['SLIDER_AUTO_PLAY_HOVER_PAUSE'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_SLIDER_AUTO_PLAY_HOVER_PAUSE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N'
        ];
    }
} else {
    $arTemplateParameters['CONTENT_POSITION'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_CONTENT_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'left' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_LEFT'),
            'center' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_CENTER'),
            'right' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_RIGHT')
        ],
        'DEFAULT' => 'left'
    ];
}

$arTemplateParameters['FOOTER_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['FOOTER_SHOW'] == 'Y') {
    $arTemplateParameters['FOOTER_POSITION'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'top' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_POSITION_TOP'),
            'bottom' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_POSITION_BOTTOM')
        ],
        'DEFAULT' => 'top',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['FOOTER_POSITION'] === 'bottom') {
        $arTemplateParameters['FOOTER_ALIGN'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_ALIGN'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'left' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_LEFT'),
                'center' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_CENTER'),
                'right' => Loc::getMessage('C_VIDEOS_TEMP1_POSITION_RIGHT')
            ],
            'DEFAULT' => 'center'
        ];
    }

    $arTemplateParameters['FOOTER_BUTTON_LINK'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_BUTTON_LINK'),
        'TYPE' => 'STRING'
    ];
    $arTemplateParameters['FOOTER_BUTTON_TEXT'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_BUTTON_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_VIDEOS_TEMP1_FOOTER_BUTTON_TEXT_DEFAULT')
    ];
}
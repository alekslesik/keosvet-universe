<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!CModule::IncludeModule('iblock'))
    return;

if (!CModule::IncludeModule('intec.core'))
    return;


$arResult['VIEW_PARAMETERS'] = [
    'DESCRIPTION_SHOW' => ArrayHelper::getValue($arParams,'DESCRIPTION_DISPLAY') == 'Y',
    'PICTURE_SHOW' => ArrayHelper::getValue($arParams,'PICTURE_DISPLAY') == 'Y',
    'TABS' => ArrayHelper::fromRange(['scroll', 'default', 'big'], $arParams['TABS_VIEW'])
];

$arSections = array();

foreach ($arResult['ITEMS'] as $arItem) {
    $iSectionId = ArrayHelper::getValue($arItem, 'IBLOCK_SECTION_ID');

    if (!empty($iSectionId))
        if (!ArrayHelper::isIn($iSectionId, $arSections))
            $arSections[] = $iSectionId;
}

if (!empty($arSections)) {
    $rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), array(
        'ID' => $arSections
    ));

    $arSections = array();

    if ($arParams['DISPLAY_TAB_ALL'] == 'Y')
        $arSections[0] = array(
            'ID' => 0,
            'NAME' => GetMessage('N_PROJECTS_N_L_DEFAULT_TAB_ALL'),
            'ITEMS' => array()
        );

    while ($arSection = $rsSections->GetNext()) {
        $arSection['ITEMS'] = array();
        $arSections[$arSection['ID']] = $arSection;
    }
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['IBLOCK_SECTION'] = null;
    $iSectionId = ArrayHelper::getValue($arItem, 'IBLOCK_SECTION_ID');

    if (!empty($iSectionId)) {
        $arSection = ArrayHelper::getValue($arSections, $iSectionId);

        if (!empty($arSection)) {
            $arItem['IBLOCK_SECTION'] = &$arSection;
            $arSections[$iSectionId]['ITEMS'][] = &$arItem;
        }
    }

    if ($arParams['DISPLAY_TAB_ALL'] == 'Y')
        $arSections[0]['ITEMS'][] = &$arItem;

    $arItem['HIDE_LINK'] = $arParams['HIDE_LINK_WHEN_NO_DETAIL'] && empty($arItem['DETAIL_TEXT']);
}

$arResult['SECTIONS'] = $arSections;
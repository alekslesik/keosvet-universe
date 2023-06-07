<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\collections\Arrays;
use intec\core\helpers\Json;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::IncludeModule('intec.startshop'))
    return;

if (!Loader::IncludeModule('iblock'))
    return;


if (!empty($arResult['ITEMS'])) {


    $arItemsSKUid = [];

    foreach ($arResult['ITEMS'] as $arItem) {
        if ($arItem['STARTSHOP']['OFFER']['OFFER'] && !ArrayHelper::isIn($arItem['STARTSHOP']['OFFER']['LINK'], $arItemsSKUid)) {
            $arItemsSKUid[] = $arItem['STARTSHOP']['OFFER']['LINK'];
        }
    }

    if (!empty($arItemsSKUid)) {
        $arSectionsItemSKU = Arrays::fromDBResult(CIBlockElement::GetList(
            [],
            ['ID' => $arItemsSKUid],
            false,
            false,
            ['ID', 'IBLOCK_SECTION_ID']
        ))->indexBy('ID')->asArray();
    }

    foreach ($arResult['ITEMS'] as $itemKey => $itemValue) {
        if ($itemValue['STARTSHOP']['OFFER']['OFFER']) {
            $arResult['ITEMS'][$itemKey]['IBLOCK_SECTION_ID'] = $arSectionsItemSKU[$itemValue['STARTSHOP']['OFFER']['LINK']]['IBLOCK_SECTION_ID'];
        }
    }

    $arSectionsID = [];

    foreach ($arResult['ITEMS'] as $arItem) {
        if (!empty($arItem['IBLOCK_SECTION_ID']) && !ArrayHelper::isIn($arItem['IBLOCK_SECTION_ID'], $arSectionsID)) {
            $arSectionsID[] = $arItem['IBLOCK_SECTION_ID'];
        }
    }

    if (!empty($arSectionsID)) {
        $arSections = Arrays::fromDBResult(
            CIBlockSection::GetList(
                ['SORT' => 'ASC'],
                ['ID' => $arSectionsID],
                false,
                ['ID', 'NAME','SECTION_PAGE_URL']
            ),
            true
        )->indexBy('ID')->asArray();

        foreach ($arResult['ITEMS'] as $itemKey => $itemValue) {
            $arResult['ITEMS'][$itemKey]['SECTION_INFO'] = $arSections[$itemValue['IBLOCK_SECTION_ID']];
        }
    }
}

$arDefaultParams = [
    'USE_ITEMS_PICTURES' => 'Y',
    'USE_BUTTON_CLEAR' => 'N',
    'USE_BUTTON_ORDER' => 'N',
    'USE_BUTTON_FAST_ORDER' => 'N',
    'USE_BUTTON_CONTINUE_SHOPPING' => 'N',
    'URL_ORDER' => '',
    'URL_CATALOG' => '',
    'USE_SUM_FIELD' => 'N',
    'USE_ADAPTABILITY' => 'N',
    'SHOW_ALERT_FORM' => 'N'
];

$arParams = ArrayHelper::merge($arDefaultParams, $arParams);

$arParams['USE_BUTTON_ORDER'] = $arParams['USE_BUTTON_ORDER'] == 'Y' && !empty($arParams['URL_ORDER']) ? 'Y' : 'N';
$arParams['USE_BUTTON_CONTINUE_SHOPPING'] = $arParams['USE_BUTTON_CONTINUE_SHOPPING'] == 'Y' && !empty($arParams['URL_CATALOG']) ? 'Y' : 'N';

if ($arParams['USE_ITEMS_PICTURES'] == 'Y') {
    foreach ($arResult['ITEMS'] as &$arItem) {
        $arItem['PICTURE'] = CStartShopToolsIBlock::GetItemPicture($arItem, 100, 100, true);

        if (empty($arItem['PICTURE']))
            $arItem['PICTURE']['SRC'] = $this->GetFolder() . '/images/image.empty.png';
    }
}

include(__DIR__.'/modifiers/quick.view.php');
include(__DIR__.'/parts/data.php');

$arSkuProductsID = [];

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!$arItem['STARTSHOP']['OFFER']['OFFER']) {
        $arItem['DATA'] = Json::encode($dData($arItem), JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true);
    } else {
        $arSkuProductsID[] = $arItem['STARTSHOP']['OFFER']['LINK'];
    }
}

if (!empty($arSkuProductsID)) {
    $rsProducts = CStartShopCatalogProduct::GetList(['SORT' => 'ASC'], ['ID' => $arSkuProductsID], [], [], false, false);

    while ($rsItem = $rsProducts->GetNext()) {
        foreach ($arResult['ITEMS'] as &$arItem) {
            foreach ($rsItem['STARTSHOP']['OFFERS'] as $arOffer) {
                if (ArrayHelper::isIn($arItem['ID'], $arOffer)) {
                    $arItem['DATA'] = Json::encode($dData($rsItem), JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true);
                }
            }
        }
    }
}
<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

?>
<div class="news-list-map" id="<?= $sTemplateId ?>_map">
    <?php
    $arContact = $arResult['MAIN'];
    $arData = [];

    if (!empty($arContact)) {
        $arCoordinates = $getMapCoordinates($arContact);

        if (!empty($arCoordinates)) {
            if ($arParams['MAP_VENDOR'] == 'google') {
                $arData['google_lat'] = $arCoordinates[0];
                $arData['google_lon'] = $arCoordinates[1];
                $arData['google_scale'] = 16;
            } else if ($arParams['MAP_VENDOR'] == 'yandex') {
                $arData['yandex_lat'] = $arCoordinates[0];
                $arData['yandex_lon'] = $arCoordinates[1];
                $arData['yandex_scale'] = 16;
            }
        }
    }

    $arData['PLACEMARKS'] = [];

    foreach ($arResult['ITEMS'] as $arItem) {
        $arCoordinates = $getMapCoordinates($arItem);

        if (!empty($arCoordinates)) {
            $arPlaceMark = [];

            $arPlaceMark['LAT'] = $arCoordinates[0];
            $arPlaceMark['LON'] = $arCoordinates[1];
            $arPlaceMark['TEXT'] = $arItem['NAME'];

            $arData['PLACEMARKS'][] = $arPlaceMark;
        }
    }
    ?>
    <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:map.google.view",
            ".default",
            [
                'MAP_ID' => $arParams['MAP_ID'],
                'API_KEY' => $arParams['API_KEY_MAP'],
                'INIT_MAP_TYPE' => 'ROADMAP',
                'MAP_DATA' => serialize($arData),
                'MAP_WIDTH' => '100%',
                'MAP_HEIGHT' => '100%',
                'OVERLAY' => 'Y',
                'CONTROLS' => [
                    0 => 'ZOOM',
                    1 => 'MINIMAP',
                    2 => 'TYPECONTROL',
                    3 => 'SCALELINE'
                ],
                'OPTIONS' => [
                    0 => 'ENABLE_SCROLL_ZOOM',
                    1 => 'ENABLE_DBLCLICK_ZOOM',
                    2 => 'ENABLE_DRAGGING'
                ],
            ],
            $component,
            ['HIDE_ICONS' => 'Y']
        );?>
    <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:map.yandex.view",
            ".default",
            [
                "COMPONENT_TEMPLATE" => ".default",
                "INIT_MAP_TYPE" => 'ROADMAP',
                "MAP_ID" => $arParams['MAP_ID'],
                "MAP_DATA" => serialize($arData),
                'MAP_WIDTH' => '100%',
                'MAP_HEIGHT' => '100%',
                'CONTROLS' => [
                    0 => "SMALLZOOM",
                    1 => "MINIMAP",
                    2 => "TYPECONTROL",
                    3 => "SCALELINE"
                ],
                'OPTIONS' => [
                    0 => "ENABLE_SCROLL_ZOOM",
                    1 => "ENABLE_DBLCLICK_ZOOM",
                    2 => "ENABLE_DRAGGING"
                ],
                'OVERLAY' => 'Y'
            ],
            $component,
            ['HIDE_ICONS' => 'Y']
        );?>
    <?php } ?>
</div>
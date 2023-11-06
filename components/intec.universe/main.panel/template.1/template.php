<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\FileHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CMain $APPLICATION
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

$itemsCount = count($arResult['ITEMS']);

if ($itemsCount > 8)
    $itemsGrid = 8;
else
    $itemsGrid = $itemsCount;

$currentPage = $APPLICATION->GetCurPage(false);

?>
<?php $oFrame = $this->createFrame()->begin() ?>
<?= Html::beginTag('div', [
    'class' => [
        'widget',
        'c-panel',
        'c-panel-template-1'
    ],
    'id' => $sTemplateId,
    'data' => [
        'svg-mode' => $arVisual['SVG']['MODE']
    ]
]) ?>
<div class="intec-content intec-content-primary">
    <div class="scrollbar scrollbar-inner" data-role="scrollbar">
        <div class="widget-body">
            <div>
                <a href="tel:+74991132770" class="phone-text">
                    <span class="value">+7 (499) 113 27 70</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/parts/script.php') ?>
<?= Html::endTag('div') ?>
<?php unset($itemsCount, $itemsGrid) ?>
<?php $oFrame->beginStub() ?>
<?php $oFrame->end() ?>
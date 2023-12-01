<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\FileHelper;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];
$arSvg = [
    'QUOTE' => FileHelper::getFileData(__DIR__.'/svg/quote.svg'),
    'PLAY' => FileHelper::getFileData(__DIR__.'/svg/play.svg'),
    'RATING' => FileHelper::getFileData(__DIR__.'/svg/rating.svg')
];

/**
 * @var Closure $vPicture()
 */
include(__DIR__.'/parts/picture.php');

?>
<div class="widget c-reviews c-reviews-template-18" id="<?= $sTemplateId ?>">
    <div class="intec-content intec-content-visible">
        <div class="intec-content-wrapper">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW'] || $arBlocks['FOOTER']['SHOW'] || $arVisual['SEND']['USE']) { ?>
                <div class="widget-header">
                    <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['FOOTER']['SHOW'] || $arVisual['SEND']['USE']) { ?>
                        <?= Html::beginTag('div', [
                            'class' => [
                                'widget-title',
                                'align-'.(
                                    $arBlocks['FOOTER']['SHOW'] || $arVisual['SEND']['USE'] ? 'left' : $arBlocks['HEADER']['POSITION']
                                )
                            ]
                        ]) ?>
                            <div class="intec-grid intec-grid-a-v-center intec-grid-a-h-end intec-grid-i-h-12">
                                <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                                    <div class="intec-grid-item">
                                        <?= $arBlocks['HEADER']['TEXT'] ?>
                                    </div>
                                <?php } ?>
                                <?php if ($arVisual['SEND']['USE']) { ?>
                                    <div class="intec-grid-item-auto">
                                        <?= Html::beginTag('div', [
                                            'class' => [
                                                'widget-send',
                                                'intec-cl' => [
                                                    'text-hover',
                                                    'border-hover',
                                                    'svg-path-stroke-hover'
                                                ]
                                            ],
                                            'data-role' => 'review.send'
                                        ]) ?>
                                            <div class="intec-grid intec-grid-a-v-center intec-grid-i-h-4">
                                                <div class="widget-send-icon intec-ui-picture intec-grid-item-auto">
                                                    <?= FileHelper::getFileData(__DIR__.'/svg/send.svg') ?>
                                                </div>
                                                <div class="widget-send-content intec-grid-item">
                                                    <?= Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_18_TEMPLATE_SEND_BUTTON_DEFAULT') ?>
                                                </div>
                                            </div>
                                        <?= Html::endTag('div') ?>
                                    </div>
                                <?php } ?>
                                <?php if ($arBlocks['FOOTER']['SHOW']) { ?>
                                    <div class="intec-grid-item-auto">
                                        <?= Html::beginTag('a', [
                                            'class' => 'widget-all',
                                            'href' => $arBlocks['FOOTER']['LINK']
                                        ]) ?>
                                            <span class="widget-all-desktop intec-cl-text-hover">
                                                <?php if (empty($arBlocks['FOOTER']['TEXT'])) { ?>
                                                    <?= Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_18_TEMPLATE_FOOTER_TEXT_DEFAULT') ?>
                                                <?php } else { ?>
                                                    <?= $arBlocks['FOOTER']['TEXT'] ?>
                                                <?php } ?>
                                            </span>
                                            <span class="widget-all-mobile intec-ui-picture intec-cl-svg-path-stroke-hover">
                                                <?= FileHelper::getFileData(__DIR__.'/svg/all.mobile.svg') ?>
                                            </span>
                                        <?= Html::endTag('a') ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <?= Html::tag('div', $arBlocks['DESCRIPTION']['TEXT'], [
                            'class' => [
                                'widget-description',
                                'align-'.(
                                    $arBlocks['FOOTER']['SHOW'] || $arVisual['SEND']['USE'] ? 'left' : $arBlocks['DESCRIPTION']['POSITION']
                                )
                            ]
                        ]) ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content">
                <?= Html::beginTag('div', [
                    'class' => Html::cssClassFromArray([
                        'widget-items' => true,
                        'owl-carousel' => $arVisual['SLIDER']['USE'],
                        'intec-grid' => [
                            '' => !$arVisual['SLIDER']['USE'],
                            'wrap' => !$arVisual['SLIDER']['USE'],
                            'a-v-stretch' => !$arVisual['SLIDER']['USE'],
                            'i-h-15' => !$arVisual['SLIDER']['USE'],
                            'i-v-25' => !$arVisual['SLIDER']['USE']
                        ]
                    ], true),
                    'data' => [
                        'role' => 'container',
                        'grid' => 1,
                        'slider' => $arVisual['SLIDER']['USE'] ? 'true' : 'false'
                    ]
                ]) ?>
                    <?php foreach ($arResult['ITEMS'] as $arItem) {

                        if (!$arItem['DATA']['PREVIEW']['SHOW'])
                            continue;

                        $sId = $sTemplateId.'_'.$arItem['ID'];
                        $sAreaId = $this->GetEditAreaId($sId);
                        $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                        $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                        $arData = $arItem['DATA'];

                        $sTag = !empty($arItem['DETAIL_PAGE_URL']) && $arVisual['LINK']['USE'] ? 'a' : 'div';

                    ?>
                        <?= Html::beginTag('div', [
                            'class' => Html::cssClassFromArray([
                                'widget-item' => true,
                                'intec-grid-item-1' => true
                            ], true)
                        ]) ?>
                            <div class="widget-item-wrapper intec-grid intec-grid-768-wrap intec-grid-a-v-center intec-grid-i-h-25" id="<?= $sAreaId ?>">
                                <div class="widget-item-picture-wrap intec-grid-item-2 intec-grid-item-768-1">
                                    <?php $vPicture($arItem) ?>
                                </div>
                                <div class="widget-item-text intec-grid-item-2 intec-grid-item-768-1">
                                    <div class="widget-item-content">
                                        <div class="widget-item-description">
                                            <div class="widget-item-description-quote intec-cl-svg-path-stroke">
                                                <?= $arSvg['QUOTE'] ?>
                                            </div>
                                            <div class="widget-item-description-text">
                                                <?= $arItem['DATA']['PREVIEW']['VALUE'] ?>
                                            </div>
                                        </div>
                                        <div class="intec-grid intec-grid-a-v-center intec-grid-a-h-between intec-grid-a-h-800-center intec-grid-i-h-5 intec-grid-i-v-5 intec-grid-wrap">
                                            <div class="intec-grid-item-auto">
                                                <div class="widget-item-name-wrap">
                                                    <?= Html::tag($sTag, $arItem['NAME'], [
                                                        'class' => 'widget-item-name',
                                                        'href' => $sTag === 'a' ? $arItem['DETAIL_PAGE_URL'] : null,
                                                        'target' => $sTag === 'a' && $arVisual['LINK']['BLANK'] ? '_blank' : null
                                                    ]) ?>
                                                </div>
                                                <?php if ($arItem['DATA']['RATING']['SHOW']) {

                                                    $isMatch = false;

                                                ?>
                                                    <div class="widget-item-rating">
                                                        <?= Html::beginTag('div', [
                                                            'class' => [
                                                                'intec-grid' => [
                                                                    '',
                                                                    'i-h-2',
                                                                    'a-h-800-center'
                                                                ]
                                                            ]
                                                        ])?>
                                                            <?php foreach ($arResult['RATING'] as $key => $value) { ?>
                                                                <?= Html::beginTag('div', [
                                                                    'class' => [
                                                                        'widget-item-rating-item',
                                                                        'intec-grid-item-auto',
                                                                        'intec-ui-picture'
                                                                    ],
                                                                    'title' => ArrayHelper::getValue(
                                                                        $arResult['RATING'],
                                                                        $arItem['DATA']['RATING']['VALUE']
                                                                    ),
                                                                    'data-active' => !$isMatch ? 'true' : 'false'
                                                                ]) ?>
                                                                    <?= $arSvg['RATING'] ?>
                                                                <?= Html::endTag('div') ?>
                                                                <?php if ($key == $arItem['DATA']['RATING']['VALUE'])
                                                                    $isMatch = true;
                                                                ?>
                                                            <?php } ?>
                                                        <?= Html::endTag('div') ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php if ($arVisual['LINK']['USE'] && !empty($arParams['LINK_TEXT'])) { ?>
                                                <div class="widget-item-link-detail intec-grid-item-auto">
                                                    <?= Html::tag('a', $arParams['LINK_TEXT'], [
                                                        'class' => [
                                                            'widget-item-link-detail-button',
                                                            'intec-ui' => [
                                                                '',
                                                                'control-button',
                                                                'scheme-current',
                                                                'mod-transparent',
                                                                'mod-round-2'
                                                            ]
                                                        ],
                                                        'href' => $arItem['DETAIL_PAGE_URL'],
                                                        'target' => $arVisual['LINK']['BLANK'] ? '_blank' : null
                                                    ]) ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                <?= Html::endTag('div') ?>
            </div>
        </div>
    </div>
    <?php if ($arVisual['VIDEO']['SHOW'] || $arVisual['SLIDER']['USE'])
        include(__DIR__.'/parts/script.php');
    ?>
</div>
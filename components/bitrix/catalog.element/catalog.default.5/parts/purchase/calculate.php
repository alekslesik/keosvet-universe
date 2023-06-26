<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\FileHelper;
use intec\core\helpers\Html;

/**
 * @var array $arSvg
 */

?>
<div class="catalog-element-cheaper" data-role="calculate" style="font-size: 14px;">
    <div class="catalog-element-cheaper-icon catalog-element-cheaper-part">
        <?= $arSvg['PRICE']['CHEAPER'] ?>
    </div>
    <?= Html::tag('div', Loc::getMessage('C_CATALOG_ELEMENT_DEFAULT_5_TEMPLATE_CALCULATE'), [
        'class' => [
            'catalog-element-cheaper-text',
            'catalog-element-cheaper-part',
            'intec-cl-text-hover'
        ],
        'style' => [
            'font-size' => '14px'
        ]
    ]) ?>
</div>
<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\component\InnerTemplate;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

?>
<?php if ($arResult['EMAIL']['SHOW']['DESKTOP']) { ?>
    <div class="widget-panel-item">
        <div class="widget-panel-item-wrapper intec-grid intec-grid-a-v-center">
            <div class="widget-container-button intec-cl-text-hover intec-cl-border-hover" data-action="forms.call.open" style="
                display: inline-block;
                position: relative;
                font-size: 12px;
                line-height: 16px;
                color: #2d2d2d;
                cursor: pointer;
                border-bottom: 1px dashed #2d2d2d;
                -webkit-transition: opacity 500ms, color 350ms, border 350ms;
                -moz-transition: opacity 500ms, color 350ms, border 350ms;
                -ms-transition: opacity 500ms, color 350ms, border 350ms;
                -o-transition: opacity 500ms, color 350ms, border 350ms;
                transition: opacity 500ms, color 350ms, border 350ms;
            ">
                <?= Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP1_BUTTON') ?>
            </div>
            <?php include(__DIR__ . '../../../../parts/forms/call.php') ?>
        </div>
    </div>
<?php } ?>
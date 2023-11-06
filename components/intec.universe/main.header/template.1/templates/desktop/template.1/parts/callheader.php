<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\component\InnerTemplate;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

?>

<?php if ($arResult['FORMS']['CALL']['SHOW']) { ?>
    <div class="widget-panel-item">
        <div class="widget-panel-item-wrapper intec-grid intec-grid-a-v-center">
            <div class="widget-container-button intec-cl-text-hover intec-cl-border-hover callheader" data-action="forms.call.open" style="">
                <?= Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP1_BUTTON') ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        template.load(function(data) {
            var app = this;
            var $ = app.getLibrary('$');
            var root = data.nodes;
            var button = $('[data-action="forms.call.open"]', root);

            button.on('click', function() {
                app.api.forms.show({
                    'id': 1,
                    'template': '.default',
                    'parameters': {
                        'AJAX_OPTION_ADDITIONAL': 'i-4-intec-universe-main-header-template-1-dZcvT5yLZEp0_FORM_CALL',
                        'CONSENT_URL': '/company/consent/'
                    },
                    'settings': {
                        'title': 'Заказать звонок'
                    }
                });

                app.metrika.reachGoal('forms.open');
                app.metrika.reachGoal('forms..open');
            });
        }, {
            'name': '[Component] intec.universe:main.header (template.1) > popup-form-call)',
            'nodes': '#i-4-intec-universe-main-header-template-1-dZcvT5yLZEp0',
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>
<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\FileHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);



?>

<?php if ($arResult["SECTION"]["UF_MAIN_HEADER"] !== null && $arResult["SECTION"]["UF_MAIN_HEADER"] !== "") { ?>
    <?php $main_header = $arResult["SECTION"]["UF_MAIN_HEADER"]; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Находим элемент с id "pagetitle"
            var pageTitleMain = document.getElementById("pagetitle pagetitle_main_header");

            // Заменяем содержимое элемента
            if (pageTitleMain) {
                pageTitleMain.innerHTML = "<?php echo CUtil::JSEscape($main_header); ?>"; // Используем CUtil::JSEscape для корректного экранирования
            }
        });
    </script>
<?php } ?>

<?php if ($arResult["SECTION"]["UF_ADD_HEADER"] !== null && $arResult["SECTION"]["UF_ADD_HEADER"] !== "") { ?>
    <?php $add_header = $arResult["SECTION"]["UF_ADD_HEADER"]; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Находим элемент с id "pagetitle_add_header"
            var pageTitleAdd = document.getElementById("pagetitle_add_header");

            // Проверяем, найден ли элемент, прежде чем обновить его содержимое
            if (pageTitleAdd) {
                // Создаем новый HTML-код с учетом значения из PHP и добавляем &nbsp;&nbsp;&nbsp;&nbsp; в начало
                var newContent = "&nbsp;&nbsp;&nbsp;&nbsp;" + "<?php echo CUtil::JSEscape($add_header); ?>";

                // Заменяем содержимое элемента
                pageTitleAdd.innerHTML = newContent;
            }
        });
    </script>

<?php } else { ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Находим элемент с id "pagetitle_add_header"
            var addHeaderElement = document.getElementById("pagetitle_add_header");

            // Проверяем, найден ли элемент, прежде чем его скрыть
            if (addHeaderElement) {
                // Скрываем элемент
                addHeaderElement.style.display = "none";
            }
        });
    </script>
<?php } ?>


<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Находим элемент с id "pagetitle"
        var pageTitle = document.getElementById("pagetitle");

        // Заменяем содержимое элемента
        if (pageTitle) {
            pageTitle.innerHTML = "Новый заголовок 999"; // Замените на нужный текст
        }
    });
</script> -->

<?php
if (empty($arResult['SECTIONS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

$arPictureSize = [
    'width' => 48,
    'height' => 48
];

function declensionWord($number, $word)
{
    $array = [2, 0, 1, 1, 1, 2];
    echo $word[($number % 100 > 4 && $number % 100 < 20) ? 2 : $array[($number % 10 < 5) ? $number % 10 : 5]];
}

$arWords = [
    Loc::getMessage('C_CATALOG_SECTION_LIST_CATALOG_TILE_9_DECLENSION_WORD_1'),
    Loc::getMessage('C_CATALOG_SECTION_LIST_CATALOG_TILE_9_DECLENSION_WORD_2'),
    Loc::getMessage('C_CATALOG_SECTION_LIST_CATALOG_TILE_9_DECLENSION_WORD_3'),
];
?>

<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section-list',
        'c-catalog-section-list-catalog-tile-7'
    ],
    'data-picture-size' => $arVisual['PICTURE']['SIZE']
]) ?>
<div class="catalog-section-list-items intec-grid intec-grid-wrap intec-grid-a-v-sretch">
    <?php foreach ($arResult['SECTIONS'] as $arSection) {

        $sId = $sTemplateId . '_' . $arSection['ID'];
        $sAreaId = $this->GetEditAreaId($sId);
        $this->AddEditAction($sId, $arSection['EDIT_LINK']);
        $this->AddDeleteAction($sId, $arSection['DELETE_LINK']);

        $arPicture = [
            'TYPE' => 'picture',
            'SOURCE' => null,
            'ALT' => null,
            'TITLE' => null
        ];

        if (!empty($arSection['PICTURE'])) {
            if ($arSection['PICTURE']['CONTENT_TYPE'] === 'image/svg+xml') {
                $arPicture['TYPE'] = 'svg';
                $arPicture['SOURCE'] = $arSection['PICTURE']['SRC'];
            } else {
                $arPicture['SOURCE'] = CFile::ResizeImageGet($arSection['PICTURE'], $arPictureSize, BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                if (!empty($arPicture['SOURCE'])) {
                    $arPicture['SOURCE'] = $arPicture['SOURCE']['src'];
                } else {
                    $arPicture['SOURCE'] = null;
                }
            }
        }

        if (empty($arPicture['SOURCE'])) {
            $arPicture['TYPE'] = 'picture';
            $arPicture['SOURCE'] = SITE_TEMPLATE_PATH . '/images/picture.missing.png';
        } else {
            $arPicture['ALT'] = $arSection['PICTURE']['ALT'];
            $arPicture['TITLE'] = $arSection['PICTURE']['TITLE'];
        }
    ?>
        <?= Html::beginTag('div', [
            'id' => $sAreaId,
            'class' => Html::cssClassFromArray([
                'catalog-section-list-item' => true,
                'intec-grid-item' => [
                    $arVisual['COLUMNS'] => true,
                    '1024-3' => $arVisual['COLUMNS'] >= 4,
                    '768-2' => $arVisual['COLUMNS'] >= 3,
                    '500-1' => true
                ]
            ], true),
        ]) ?>
        <?= Html::beginTag('div', [
            'class' => Html::cssClassFromArray([
                'catalog-section-list-item-wrapper' => true,
                'intec-grid' => [
                    '' => true,
                    'a-v-center' => true
                ]
            ], true)
        ]) ?>
        <?php if ($arVisual['PICTURE']['SHOW']) { ?>
            <div class="intec-grid-item-auto">
                <?= Html::beginTag('a', [
                    'class' => Html::cssClassFromArray([
                        'catalog-section-list-item-picture-wrap' => true,
                        'catalog-section-list-item-picture' => true,
                        'intec-ui-picture' => true,
                        'intec-image-effect' => true,
                        'intec-cl-svg' => $arVisual['SVG']['COLOR'] == 'theme' ? true : false
                    ], true),
                    'href' => $arSection['SECTION_PAGE_URL'],
                    'target' => $arVisual['LINK']['BLANK'] ? '_blank' : null,
                ]) ?>
                <?php if ($arPicture['TYPE'] === 'svg') { ?>
                    <?= FileHelper::getFileData('@root/' . $arPicture['SOURCE']) ?>
                <?php } else { ?>
                    <?= Html::img($arPicture['SOURCE'], [
                        'alt' => $arPicture['ALT'],
                        'title' => $arPicture['TITLE'],
                        'loading' => 'lazy',
                        'data' => [
                            'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                            'original' => $arVisual['LAZYLOAD']['USE'] ? $arPicture['SOURCE'] : null
                        ]
                    ]) ?>
                <?php } ?>
                <?= Html::endTag('a') ?>
            </div>
        <?php } ?>
        <div class="intec-grid-item">
            <?= Html::beginTag('a', [
                'class' => [
                    'catalog-section-list-item-name',
                    'intec-cl-text-hover'
                ],
                'href' => $arSection['SECTION_PAGE_URL'],
                'target' => $arVisual['LINK']['BLANK'] ? '_blank' : null
            ]) ?>
            <?= $arSection['NAME'] ?>
            <?= Html::endTag('a') ?>
            <?php if ($arVisual['ELEMENTS']) { ?>
                <div class="catalog-section-list-item-count">
                    <?= $arSection['ELEMENT_CNT'] ?> <?= declensionWord($arSection['ELEMENT_CNT'], $arWords) ?>
                </div>
            <?php } ?>
        </div>
        <?= Html::endTag('div') ?>
        <?= Html::endTag('div') ?>
    <?php } ?>
</div>
<?= Html::endTag('div') ?>
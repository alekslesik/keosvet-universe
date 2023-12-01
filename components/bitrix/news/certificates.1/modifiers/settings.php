<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\template\Properties;

/**
 * @var array $arParams
 */

if (!defined('EDITOR')) {
    if (Properties::get('template-images-lazyload-use'))
        $arParams['LAZYLOAD_USE'] = 'Y';

    $arParams['LIST_TEMPLATE'] = Properties::get('sections-certificates-template');
}
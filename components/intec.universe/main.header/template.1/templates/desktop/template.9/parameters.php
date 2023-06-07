<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\UnsetArrayValue;

$arReturn = [];
$arReturn['LOGOTYPE_WIDTH'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_LOGOTYPE_WIDTH'),
    'TYPE' => 'STRING',
    'DEFAULT' => '180'
];
$arReturn['ADDRESS_SHOW'] = new UnsetArrayValue();
$arReturn['EMAIL_SHOW'] = new UnsetArrayValue();
$arReturn['TAGLINE_SHOW'] = new UnsetArrayValue();

return $arReturn;
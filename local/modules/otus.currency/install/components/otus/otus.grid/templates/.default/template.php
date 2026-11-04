<?php

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Grid\Options;
use Bitrix\Main\UI\PageNavigation;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */
$this->setFrameMode(true);
$gridId = 'currency_grid_id';
?>
<?php
$APPLICATION->includeComponent(
    "bitrix:main.ui.grid",
    "",
    [
        "GRID_ID" => $gridId,
        "NAV_OBJECT" => $arResult['NAV_OBJECT'],
        "COLUMNS" => $arResult['COLUMNS'],
        "ROWS" => $arResult['LISTS'],
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "SHOW_ROW_CHECKBOXES" => $arResult['SHOW_ROW_CHECKBOXES'],
        "SHOW_SELECTED_COUNTER" => true,
        "SHOW_PAGESIZE" => false,
        "TOTAL_ROWS_COUNT" => $arResult['COUNT']
    ]
);
?>

<?php

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */
 
$APPLICATION->SetTitle(Loc::getMessage('OTUS_GRID_TITLE'));
?>

<div id="otus-grid" class="otus-grid"></div>

<?
print_r(sage($arResult));
?>


<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

if (empty($arResult["CURRENCY_RATE"])) {
    echo Loc::getMessage('CURRENCY_RATE_EMPTY');
    die;
}

foreach($arResult["CURRENCY_RATE"] as $key=>$item) {
    echo "<b>".Loc::getMessage('CURRENCY_RATE_TITLE').": </b>";
    echo CurrencyFormat(1, $key)."  =  {$item}"; 
}

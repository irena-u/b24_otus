<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Otus\Currency\Currency;
use App\Debug\Log;
use Bitrix\Main\SystemException;

class OtusGridComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array
    {
        // TODO: prepare or format component params
        //$arParams['USERNAME'] ??= 'default value';

        return $arParams;
    }

    public function executeComponent(): void
    {
        if (!Loader::IncludeModule("otus.currency")) {
            throw new SystemException('Не установлен модуль Отус.Валюты');
        }
        $this->prepareResult();

        $this->includeComponentTemplate();
    }

    private function prepareResult(): void
    {
        try {
            $this->arResult['CURRENCIES'] = [];
            $this->arResult['CURRENCIES'] = Currency::getCurrencyList();
        } catch (\Throwable $e) {
            ShowError($e->getMessage());
        }
    }
}

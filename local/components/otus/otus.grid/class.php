<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Otus\Currency\Currency;
use Otus\Currency\Models\CurrencyTable;
use App\Debug\Log;
use Bitrix\Main\SystemException;
use Bitrix\Main\Context;
use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\Contract;
use Bitrix\Main\UI\PageNavigation;

class OtusGridComponent extends CBitrixComponent
{
    protected $request;

    public function onPrepareComponentParams($arParams): array
    {
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
            $count = CurrencyTable::getCount();
            $nav = new PageNavigation("currency_grid_id");
            $nav->allowAllRecords(false)
                ->setPageSize($this->arParams['nPageSize'] ?? 5)
                ->setRecordCount($count)
                ->initFromUri();

            $this->arResult['SHOW_ROW_CHECKBOXES'] = false;

            if ($this->arParams['SHOW_CHECKBOXES'] == 'Y') {
                $this->arResult['SHOW_ROW_CHECKBOXES'] = true;
            }
            $currencyTable = new Currency();
            $this->arResult['COLUMNS'] = $currencyTable->getColumn(); // получаем названия полей таблицы

            $this->arResult['nPageSize'] = (empty($this->arParams['nPageSize'])) ? 5 : $this->arParams['nPageSize'];

            $this->arResult['LISTS'] = [];
            $this->arResult['LISTS'] = Currency::getCurrencyList($nav->getLimit(), $nav->getOffset());
            $this->arResult['NAV_OBJECT'] = $nav;
            $this->arResult['COUNT'] = $count; // количество записей
        } catch (\Throwable $e) {
            ShowError($e->getMessage());
        }
    }
}

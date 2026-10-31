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

class OtusGridComponent extends CBitrixComponent
{
    protected $request;

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
            $this->$request = Application::getInstance()->getContext()->getRequest();
            $gridId = 'currency_grid_id';
            if (isset($this->$request[$gridId])) {
                $page = explode('page-', $this->$request[$gridId]);
                $page = $page[1];
            } else {
                $page = 1;
            }

            $this->arResult['SHOW_ROW_CHECKBOXES'] = false;

            if ($this->arParams['SHOW_CHECKBOXES'] == 'Y') {
                $this->arResult['SHOW_ROW_CHECKBOXES'] = true;
            }
            $currencyTable = new Currency();
            $this->arResult['COLUMNS'] = $currencyTable->getColumn(); // получаем названия полей таблицы

            $this->arResult['nPageSize'] = (empty($this->arParams['nPageSize'])) ? $selectedPageSize : $this->arParams['nPageSize'];

            $this->arResult['LISTS'] = [];
            $this->arResult['LISTS'] = Currency::getCurrencyList($page,$this->arParams['nPageSize']);
            $this->arResult['COUNT'] = CurrencyTable::getCount(); // количество записей
        } catch (\Throwable $e) {
            ShowError($e->getMessage());
        }
    }
}

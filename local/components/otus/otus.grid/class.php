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
use Bitrix\Main\Filter\Filter;
use Bitrix\Main\Config\Option;

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
            $arFilter = array();
            $this->arResult["FILTER"] = array(
                array(
                    "id" => "ID",
                    "name" => "ID",
                    "type" => "number",
                    "filterable" => true
                ),
            );
            $this->arResult['GRID_ID'] = 'currency_grid_id';
            $this->arResult['FILTER_ID'] = 'filter_currency_grid_id';

            //$filterOption = new Bitrix\Main\UI\Filter\Options($this->arResult['FILTER_ID']);

            if (!empty($this->arParams['FILTER']) && is_array($this->arParams['FILTER'])) {
                $arFilter = $this->arParams['FILTER'];
            }
            $request = Application::getInstance()->getContext()->getRequest();

            if (empty($this->arParams['FILTER']) && $request->get('FILTER')) {
                $arFilter = ["COMPANY_ID"=>(int)$request->get('FILTER')];
            }

            $count = CurrencyTable::getCount($arFilter);
            
            $pageSize = $this->arParams['nPageSize'] ?? Option::get('otus.currency', 'pagesize', 5);

            $nav = new PageNavigation("currency_grid_id");

            $nav->allowAllRecords(false)
                ->setPageSize($pageSize)
                ->setRecordCount($count)
                ->initFromUri();

            // offset и limit
            $offset = $nav->getOffset();
            $limit  = $nav->getLimit();

            // страховка: по какой-то причине limit=0 — ставим вручную
            if ($limit <= 0) {
                $limit = $this->arParams['nPageSize'];
            }
            $this->arResult["NAV_OBJECT"] = $nav;
            $this->arResult["CURRENT_PAGE"] = $nav->getCurrentPage();
            $this->arResult['SHOW_ROW_CHECKBOXES'] = false;

            if ($this->arParams['SHOW_CHECKBOXES'] == 'Y') {
                $this->arResult['SHOW_ROW_CHECKBOXES'] = true;
            }
            $currencyTable = new Currency();
            $this->arResult['COLUMNS'] = $currencyTable->getColumn(); // получаем названия полей таблицы

            $this->arResult['nPageSize'] = (empty($this->arParams['nPageSize'])) ? 5 : $this->arParams['nPageSize'];

            $this->arResult['LISTS'] = [];
            $this->arResult['LISTS'] = Currency::getCurrencyList($limit, $offset, $arFilter);
            $this->arResult['NAV_OBJECT'] = $nav;
            $this->arResult['COUNT'] = $count;

        } catch (\Throwable $e) {
            ShowError($e->getMessage());
        }
    }
}

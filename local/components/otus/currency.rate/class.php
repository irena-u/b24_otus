<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */

// global $INTRANET_TOOLBAR;
// use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use App\Models\ORM\CurrencyTable;
use App\Debug\Log;
use Bitrix\Main\SystemException;

class CurrencyRateComponent extends \CBitrixComponent
{
    protected ?string $baseCurrency = null;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
    */
    public function onPrepareComponentParams($arParams)
    {
        // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
        $arParams['SHOW_CURRENCY'] = trim((string)($arParams['SHOW_CURRENCY'] ?? ''));
        return $arParams;
    }


    /**
     * Получат курс валюты, выбранной в параметрах
     *
     * @param string $currency
     * @return array
     */
    private function getRate(string $currency): array
    {
        $rate = [];
        $dbRate = CurrencyTable::getList([
            'select' => [
                'CURRENCY','AMOUNT'
            ],
            'filter' => [
                '=CURRENCY' => $currency,
            ],
        ]);
        if ($arRate = $dbRate->fetch()) {
            $rate[$arRate['CURRENCY']] = CurrencyFormat((float)$arRate['AMOUNT'], $this->baseCurrency);
        } else {
            Log::addLog("component currency.rate - Курс валюты ".$currency." не найден");
        }
        return $rate;
    }


    /**
     * Точка входа в компонент
     */
    public function executeComponent()
    {
        try {
            if(!Loader::IncludeModule("currency")) {
                throw new SystemException('Не установлен модуль Валюты');
            }
            $this->baseCurrency = CurrencyTable::getBaseCurrency();

            if (!$this->baseCurrency) {
                throw new SystemException('Базовая валюта не настроена');
            }

            $this->arResult['BASE_CURRENCY'] = $this->baseCurrency;
            $this->arResult['CURRENCY_RATE'] = $this->getRate($this->arParams['SHOW_CURRENCY']);
            // подключаем шаблон
            $this->IncludeComponentTemplate();

        } catch (\Throwable $e) {
            ShowError($e->getMessage());
        }

    }


}

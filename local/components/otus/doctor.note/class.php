<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use App\Debug\Log;
use Bitrix\Main\SystemException;

class DoctorNoteComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array
    {
        // TODO: prepare or format component params
        $arParams['SERVICE_ID'] ??= '0';
        $arParams['DOCTOR_ID'] ??= '0';

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->prepareResult();

        $this->includeComponentTemplate();
    }

    private function prepareResult(): void
    {
        // TODO: prepare result for template.php
        $this->arResult['SERVICE'] = [
			'ID'	=> 'id',
            'NAME' => 'name',
            'DOCTOR' => 'doctor',
        ];
    }
}

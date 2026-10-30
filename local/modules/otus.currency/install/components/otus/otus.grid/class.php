<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

class OtusGridComponent extends CBitrixComponent
{
	public function onPrepareComponentParams($arParams): array
	{
		// TODO: prepare or format component params
		$arParams['USERNAME'] ??= 'default value';
		
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
		$this->arResult['FRUITS'] = [
			'apple',
			'banana',
			'ananas',
		];
	}
}

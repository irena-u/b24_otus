<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
use App\Models\ORM\CurrencyTable;

if(!CModule::IncludeModule("catalog"))
	return;

$arComponentParameters = array(
	"GROUPS" => array(
		"LIST"=>array(
			"NAME"=>GetMessage("VIEW_PARAMETERS"),
			"SORT"=>"300"
		)
	),
	"PARAMETERS" => array(
		"SHOW_CURRENCY" =>  array(
			"PARENT" => "LIST",
			"NAME"=>GetMessage("CURRENCY"),
			"TYPE"=>"LIST",
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'VALUES' => CurrencyTable::getCurrencyList(),
			'DEFAULT' => CurrencyTable::getBaseCurrency(),
		),
	)
);

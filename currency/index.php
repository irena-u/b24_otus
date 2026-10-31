<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Список валют");?><?$APPLICATION->IncludeComponent(
	"otus:otus.grid", 
	".default", 
	[
		"SHOW_CHECKBOXES" => "Y",
		"nPageSize" => "5",
		"COMPONENT_TEMPLATE" => ".default"
	],
	false
);?><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
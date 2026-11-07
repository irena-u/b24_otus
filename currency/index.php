<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Список валют");?><?$APPLICATION->IncludeComponent(
	"otus:otus.grid",
	"",
	Array(
		"SHOW_CHECKBOXES" => "Y",
		"nPageSize" => "5"
	)
);?><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
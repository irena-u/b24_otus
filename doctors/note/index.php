<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Бронирование");
?><?$APPLICATION->IncludeComponent(
	"otus:doctor.note",
	"",
	Array(
		"DOCTOR_ID" => "0",
		"SERVICE_ID" => "0"
	)
);?>
<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Валюты");?>Кастомный компонент, который выводит курс выбранной валюты<br>
<?$APPLICATION->IncludeComponent(
	"otus:currency.rate",
	"",
	Array(
		"SHOW_CURRENCY" => "EUR"
	)
);?>
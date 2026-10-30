<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Список валют");?>
<?php

$APPLICATION->IncludeComponent(
        'otus:otus.grid',
        '',
        [],
);

?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
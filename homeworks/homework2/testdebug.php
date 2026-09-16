<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("ДЗ #2: Отладка и логирование");
?>
<?php
//var_dumper
// print_r('<pre>');
// print_r('dump($_SERVER): ');
// print_r(dump($_SERVER));
// print_r('</pre>');
?>
<?php
//sage
print_r('<pre>');
print_r('sage($_SERVER): ');
print_r(sage($_SERVER));
print_r('</pre>');
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
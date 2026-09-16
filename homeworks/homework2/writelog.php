<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("Добавление в лог");
use App\Debug\Log;
?>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="/local/logs/custom_debug.log">Файл лога</a>,
            в лог добавленно 'Открыта страница writelog.php'
        </li>
    </ul>
<?
//записываем в лог текущую дату и время
Log::addLog(date('d.m.Y H:i:s'));

?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
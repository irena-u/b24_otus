<?
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("ДЗ #1: Создание и настройка проекта в VScode");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');


?>
<h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

<h4 class="mb-3">Пояснительная записка</h4>
    <ul>
        <li>Настроена dev-площадка на VirtualBox</li>
        <li>Установлен Bitrix24 (<a href="https://ct048661.tw1.ru/" target="_blank">production</a>)</li>
        <li>Настроена авторизация по ssh-ключу на площадках</li>
        <li>Настроен git-репозиторий, перенесены изменения c dev на prod</li>
        <li>Установлена библиотека var-dumper через Composer</li>
    </ul>
<br>
<br>
<hr>




<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
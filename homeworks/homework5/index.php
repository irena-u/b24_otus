<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #5: Компонент списка таблицы БД");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

?>
    <h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

    <h4 class="mb-3">Пояснительная записка</h4>
    <div>
        <ul><li>Сгенерировала ORM для таблицы b_catalog_currency, может это было избыточно и можно было стандартный API использовать, но хотелось попробовать</li>
        <li>Создала кастомный компонент в пространстве имен otus</li>
        <li>В параметрах компонента вызываю методы getCurrencyList и getBaseCurrency для выбора валют из списка<br>
        методы разместила в том же классе где ORM, хотя логичней было бы хранить в модуле, но модуль сейчас создавать не требуется</li>
        <li>В компоненте вызываю метод getRate с выбранным параметром</li>
        <li>В шаблоне вывожу полученный курс валюты</li>
    </div>
    <br>
    <br>
    <hr>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-success text-white">
            Файлы проекта
        </div>
        <ul class="list-group list-group-flush">

            <li class="list-group-item list-group-item-action">
                <a href="/otus/currencies.php"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на тестовую страницу с компонентом
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр
                    </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2FApp%2FModels%2FORM%2FCurrencyTable.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    ORM
                </span>
                <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fcomponents%2Fotus%2Fcurrency.rate%2Fclass.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Компонент
                </span>
                <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
        </ul>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
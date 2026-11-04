<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #6: Написание своего модуля");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');


?>
<h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

<h4 class="mb-3">Пояснительная записка</h4>
<div>
    <ul>
        <li>Создана таблица со списком валют аналогичная стандартной.</li>
        <li>Написан ORM-класс для работы с таблицей</li>
        <li>Создан компонент для вывода списка валют в публичной части с использованием grid</li>
        <li>Создан модуль, компонент и публичная часть копируются при установке модуля</li>
        <li>Добавлен обработчик события onEntityDetailsTabsInitialized - добавляет пункт меню в CRM компании, выводит список валют</li>
        <li>Добавлен параметр, который позволяет фильтровать данные из таблицы по выбранной компании</li>
    </ul>
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
                <a href="/currency/"
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
                <a href="/bitrix/admin/settings.php?mid=otus.currency&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на страницу с настройками модуля
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр в админке
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/partner_modules.php?lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на установленные решения, модуль: otus.currency
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр в админке
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/perfmon_table.php?lang=ru&table_name=b_otus_currency"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на таблицу
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр в админке
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fmodules%2Fotus.currency%2Finstall%2Findex.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (install модуля)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fmodules%2Fotus.currency%2Flib%2FModels%2FCurrencyTable.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (ORM)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fmodules%2Fotus.currency%2Flib%2FCurrency.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (класс для подготовки данных для grid)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fmodules%2Fotus.currency%2Flib%2FEvents%2FCrmMenu.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (класс обработчика события)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_admin.php?lang=ru&path=%2Flocal%2Fcomponents%2Fotus%2Fotus.grid&site=s1"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (компонент)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
        </ul>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
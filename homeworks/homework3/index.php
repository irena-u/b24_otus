<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #3: Связывание моделей");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

?>
    <h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

    <h4 class="mb-3">Пояснительная записка</h4>
    <ul>
        <li>Создано 2 списка с врачами и процедурами которые они выполняют;</li>
        <li>Процедуры привязаны к врачам;</li>
        <li>Создана страница список врачей, список процедур и страница где мы кликаем по врачу и видим процедуры которые он делает.</li>
        <li>Использован абстрактный класс для запросов к инфоблоку;
        <li>Реализована возможность добавления процедуры, врача и процедур, которые он выполняет.
    </ul>
    <br>
    <br>
    <hr>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-success text-white">
            Файлы проекта
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action">
                <a href="/doctors/"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Список врачей
                </span>
                    <span class="badge bg-primary">
                   Ссылка на просмотр
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/doctors/?page=services"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Список процедур
                </span>
                    <span class="badge bg-success">
                   Ссылка на просмотр
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/doctors/index.php?page=ivanov"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Врач и процедуры
                </span>
                    <span class="badge bg-secondary">
                   Ссылка на просмотр
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=/local/App/Models/Lists/DoctorsPropertyValuesTable.php"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (связь таблиц и ORM)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
        </ul>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
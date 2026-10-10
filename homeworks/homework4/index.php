<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #4: Создание своих таблиц БД и написание модели данных к ним");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

?>
    <h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

    <h4 class="mb-3">Пояснительная записка</h4>
    <div>
        Таблица с данными для хранения расписания конференции. Связана с инфоблоками: Участники, Аудитории, Конференции.<br>
        Добавлен класс ORM для описания таблицы с данными, написана связь с полей таблицы с инфоблоками. Для инфоблока Участники написана связь с полями инфоблока.<br>
        В публичной части созданы технические страницы: добавление таблицы, удаление таблицы, добавление в таблицу демо-данных.<br>
        Создано представление для вывода данных из таблицы.
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
                <a href="/bitrix/admin/perfmon_table.php?lang=ru&table_name=b_app_models_orm_conf_schedule"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на таблицу
                </span>
                    <span class="badge bg-success">
                   Ссылка на просмотр в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=20&type=lists&lang=ru&find_section_section=0&SECTION_ID=0&apply_filter=Y"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Список на ИБ 1 - Участники конференций
                </span>
                    <span class="badge bg-primary">
                   Ссылка на просмотр в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=22&type=lists&lang=ru&find_section_section=0&SECTION_ID=0&apply_filter=Y"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Список на ИБ 2 - Аудитории
                </span>
                    <span class="badge bg-primary">
                   Ссылка на просмотр в админке
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/conf_schedule/"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на тестовую страницу
                </span>
                    <span class="badge bg-secondary">
                   Ссылка на просмотр
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Fconf_schedule%2Findex.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на тестовую страницу
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2FApp%2FModels%2FORM%2FConfScheduleTable.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылки на просмотр кода основных файлов ДЗ (связь таблиц, ORM, классы  и т.д.)
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
        </ul>
    </div>





<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
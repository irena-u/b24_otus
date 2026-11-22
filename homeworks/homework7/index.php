<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #7: Создание кастомных полей и встраивание их в систему");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');


?>
<h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

<h4 class="mb-3">Пояснительная записка</h4>
<div>
    <ul>
    <li>Создала список Бронирование</li>
    <li>Создала класс кастомного типа свойства инфоблока наподобие Привязка к элементу инфоблока</li>
    <li>Написала контроллер компонента для сохранения данных</li>
    <li>При клике на значение в публичной части появляется попап с формой. Показывает поля ФИО, дата (ближайшие 2 недели) и время</li>
    <li>При клике на кнопку проверяет есть ли запись у этого врача на выбранное время</li>
    <li>Если записи нет, то сохраняет запись в инфоблок Бронирование</li>
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
                <a href="/services/lists/23/view/0/"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на список бронирование
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр
                </span>
                </a>
            </li>

            <li class="list-group-item list-group-item-action">
                <a href="/services/lists/18/view/0/"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Ссылка на список врачей
                </span>
                    <span class="badge bg-warning">
                    Ссылка на просмотр
                </span>
                </a>
            </li>
            <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2FApp%2FUserTypes%2FCIBlockPropertyServicesNote.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Класс, реализующий пользовательский тип свойства инфоблока "Процедуры Запись"
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
                <li class="list-group-item list-group-item-action">
                <a href="/bitrix/admin/fileman_file_view.php?path=%2Flocal%2Fcomponents%2Fotus%2Fdoctor.note%2Fclass.php&site=s1&lang=ru"
                   class="d-flex justify-content-between align-items-center">
                <span>
                    Контроллер компонента
                </span>
                    <span class="badge bg-warning">
                    файл в админке
                </span>
                </a>
            </li>
        </ul>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
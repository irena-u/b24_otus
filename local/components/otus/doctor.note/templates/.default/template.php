<?php

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$APPLICATION->SetTitle(Loc::getMessage('DOCTOR_NOTE_TITLE'));
\Bitrix\Main\UI\Extension::load("ui.forms");

$fioValue = $arResult["FIO"] ?? "";
$dateValue = $arResult["DATE"] ?? "";
$timeValue = $arResult["TIME"] ?? "";
$serviceID = $arResult['SERVICE']['ID'] ?? "Процедура не выбрана";
$serviceName = $arResult['SERVICE']['NAME'] ?? "Процедура не выбрана";
$doctorName = $arResult['SERVICE']['DOCTOR'] ?? "Врач не выбран";

// Генерация списка времени с шагом 30 минут (с 8:00 до 17:30)
$timeOptions = [];
$start = new DateTime('08:00');
$end = new DateTime('17:30');
$interval = new DateInterval('PT30M');
$period = new DatePeriod($start, $interval, $end->modify('+1 minute'));


foreach ($period as $dt) {
    $timeStr = $dt->format('H:i');
    $timeOptions[$timeStr] = $timeStr;
}

$dateOptions = [];


//Генерация дат на ближайшие 2 недели, кроме выходных
// Начало: завтра
$startDate = new DateTime('tomorrow');
$startDate->setTime(0, 0, 0);

// Конец: через 2 недели от завтра
$endDate = (new DateTime('tomorrow'))->modify('+13 days'); // 14 дней включая завтра

// Итерация по дням
$datePeriod = new DatePeriod(
    $startDate,
    new DateInterval('P1D'),
    $endDate->modify('+1 day') // +1 день, чтобы включить последнюю дату в период
);

// Массивы для русских названий дней недели и месяцев
$weekDays = [
    1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт',
    5 => 'Пт', 6 => 'Сб', 7 => 'Вс'
];
$months = [
    1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
    5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
    9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
];

foreach ($datePeriod as $dt) {
    // Пропускаем субботу (6) и воскресенье (7)
    // Формат 'N': 1 (пн) - 7 (вс)
    $dayOfWeek = (int)$dt->format('N');
    if ($dayOfWeek >= 6) {
        continue;
    }

    $dateValue = $dt->format('Y-m-d'); // значение для value (БД)
    $dateLabel = $dt->format('d') . ' ' . $months[(int)$dt->format('n')] 
               . ' ' . $dt->format('Y') 
               . ' (' . $weekDays[$dayOfWeek] . ')'; // отображаемый текст

    $dateOptions[$dateValue] = $dateLabel;
}

?>

<form method="post" action="<?= POST_FORM_ACTION_URI ?>" class="doctor-note-form">
    <!-- Обязательное поле sessid для защиты -->
    <?= bitrix_sessid_post() ?>

    <div class="ui-form ui-form-line">
        <!-- ФИО -->
        <div class="ui-form-row">
            <div class="ui-form-label">
                <label class="ui-form-label-text" for="fio">ФИО</label>
            </div>
            <div class="ui-form-content">
                <div class="ui-ctl ui-ctl-textbox"><input type="text" 
                       id="fio" 
                       name="FIO" 
                       class="ui-ctl-element"
                       value="<?= htmlspecialcharsbx($fioValue) ?>" 
                       placeholder="Введите ФИО"></div>
            </div>
        </div>

        <!-- Дата и Время -->
            <div class="ui-form-row">
				<div class="ui-form-label">
					<div class="ui-ctl-label-text">Дата начала</div>
				</div>
                <div class="ui-form-content">
                    <!-- Поле Даты с календарем -->
                    <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
                        <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                        <select name="DATE" class="ui-ctl-element">
                            <?php foreach ($dateOptions as $val => $label): ?>
                                <option value="<?= $val ?>" <?= ($dateValue === $val ? 'selected' : '') ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="ui-form-row">
                <div class="ui-form-label">
					<div class="ui-ctl-label-text">Время начала</div>
				</div>
                <div class="ui-form-content">
                    <!-- Поле Времени (Выпадающий список с интервалами) -->
                    <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
                        <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                        <select name="TIME" class="ui-ctl-element">
                            <?php foreach ($timeOptions as $val => $label): ?>
                                <option value="<?= $val ?>" <?= ($timeValue === $val ? 'selected' : '') ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

        <!-- Процедура (Readonly) -->
        <div class="ui-form-row">
            <div class="ui-form-label">
                <label class="ui-form-label-text" for="procedure">Процедура</label>
            </div>
            <div class="ui-form-content">
                <div class="ui-ctl ui-ctl-textbox">
                <input type="text" 
                       id="procedure" 
                       name="SERVICE_NAME" 
                       class="ui-ctl-element" 
                       value="<?= htmlspecialcharsbx($serviceName) ?>" 
                       readonly 
                       style="background-color: #f5f5f5; cursor: not-allowed;">
                <input type="hidden" name="SERVICE_ID" value="<?= htmlspecialcharsbx($serviceID) ?>">
                </div>
            </div>
        </div>

        <!-- Врач (Readonly) -->
        <div class="ui-form-row">
            <div class="ui-form-label">
                <label class="ui-form-label-text" for="doctor">Врач</label>
            </div>
            <div class="ui-form-content">
                <div class="ui-ctl ui-ctl-textbox">
                <input type="text" 
                       id="doctor" 
                       name="DOCTOR" 
                       class="ui-ctl-element" 
                       value="<?= htmlspecialcharsbx($doctorName) ?>" 
                       readonly 
                       style="background-color: #f5f5f5; cursor: not-allowed;">
                </div>
            </div>
        </div>

        <!-- Кнопка Сохранить -->
        <div class="ui-form-row">
            <div class="ui-form-content">
                <button type="submit" name="save" value="Y" class="ui-btn ui-btn-success">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</form>

<script>
BX.ready(() => {
    const container = document.getElementById('doctor-note');
    const fruits = <?= Json::encode($arResult['SERVICE']) ?>;
    console.log(fruits);
    // render extension inside container
    // new BX.Doctor.Note({
    // 	container,
    // 	fruits,
    // });
});
</script>

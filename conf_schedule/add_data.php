<?php

use App\Models\ORM\ConfScheduleTable;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * Добавление демо-данных в таблицу ConfShedule
 */
$demoData = [
    [
        'START_DATETIME' => '10.10.2026 10:00:00',
        'END_DATETIME'   => '10.10.2026 10:30:00',
        'SPEAKER_ID'     => null,
        'ROOM_ID'        => 44,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Регистрация участников',
    ],
    [
        'START_DATETIME' => '10.10.2026 10:30:00',
        'END_DATETIME'   => '10.10.2026 11:30:00',
        'SPEAKER_ID'     => 41,
        'ROOM_ID'        => 45,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Доклад спикера А',
    ],
    [
        'START_DATETIME' => '10.10.2026 11:30:00',
        'END_DATETIME'   => '10.10.2026 12:30:00',
        'SPEAKER_ID'     => 42,
        'ROOM_ID'        => 47,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Доклад спикера B',
    ],
    [
        'START_DATETIME' => '10.10.2026 12:30:00',
        'END_DATETIME'   => '10.10.2026 13:00:00',
        'SPEAKER_ID'     => null,
        'ROOM_ID'        => 48,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Кофе-брейк',
    ],
    [
        'START_DATETIME' => '10.10.2026 13:00:00',
        'END_DATETIME'   => '10.10.2026 14:00:00',
        'SPEAKER_ID'     => 41,
        'ROOM_ID'        => 45,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Второй доклад спикера А',
    ],
    [
        'START_DATETIME' => '10.10.2026 14:00:00',
        'END_DATETIME'   => '10.10.2026 15:00:00',
        'SPEAKER_ID'     => 42,
        'ROOM_ID'        => 47,
        'CONF_ID'        => 43,
        'TOPIC'          => 'Второй доклад спикера B',
    ],
];

foreach ($demoData as $row) {
    $row['START_DATETIME'] = new \Bitrix\Main\Type\DateTime($row['START_DATETIME'], 'd.m.Y H:i:s');
    $row['END_DATETIME']   = new \Bitrix\Main\Type\DateTime($row['END_DATETIME'], 'd.m.Y H:i:s');
    $result = ConfScheduleTable::add($row);

    if (!$result->isSuccess()) {
        foreach ($result->getErrors() as $error) {
            echo $error->getMessage() . '<br>';
        }
    } else {
        echo "Запись добавлена <br>";
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

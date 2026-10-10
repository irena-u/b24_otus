<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


use App\Models\ORM\ConfScheduleTable;
use Bitrix\Main\Application;
use Bitrix\Main\ORM;

$table = ConfScheduleTable::createDbTable();
$connectionName = ConfScheduleTable::getConnectionName();

$bTableExists = Application::getConnection(ConfScheduleTable::getConnectionName())
                ->isTableExists(
                    ORM\Entity::getInstance(
                        entityName: ConfScheduleTable::class
                    )->getDBTableName()
                );
echo ($bTableExists)? 'Таблица создана' : 'Таблица отсутствует';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

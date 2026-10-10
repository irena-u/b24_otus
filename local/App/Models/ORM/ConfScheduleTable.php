<?php

namespace App\Models\ORM;

use Bitrix\Main\Application;
use Bitrix\Main\ORM;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Validators\DateValidator;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use App\Models\Lists\ConfEventsPropertyValuesTable;
use App\Models\Lists\ConfRoomsPropertyValuesTable;
use App\Models\Lists\ConfSpeakersPropertyValuesTable;

/** Описание ORM для таблицы, связывающей спикера, конференцию и аудиторию по времени */
class ConfScheduleTable extends DataManager
{
    public static function getDBTableName()
    {
        return 'conf_schedule';
    }

    public static function getConnectionName()
    {
        return 'default';
    }

    public static function createDbTable()
    {
        if (
            !Application::getConnection(ConfScheduleTable::getConnectionName())
            ->isTableExists(
                ORM\Entity::getInstance(ConfScheduleTable::class)->getDBTableName()
            )
        ) {
            ORM\Entity::getInstance(ConfScheduleTable::class)->createDbTable();
        }
    }

    public static function deleteDbTable()
    {
        if (
            Application::getConnection(ConfScheduleTable::getConnectionName())
                ->isTableExists(
                    ORM\Entity::getInstance(
                        entityName: ConfScheduleTable::class
                    )->getDBTableName()
                )
        ) {
            Application::getConnection(ConfScheduleTable::getConnectionName())
        ->queryExecute(sql: 'drop table if exists ' . ORM\Entity::getInstance(entityName: ConfScheduleTable::class)
            ->getDBTableName());
        }
    }


    public static function getMap()
    {
        $confIblockClass = \Bitrix\Iblock\Iblock::wakeUp(21)->getEntityDataClass();
        $speakerIblockClass = \Bitrix\Iblock\Iblock::wakeUp(20)->getEntityDataClass();
        $roomIblockClass = \Bitrix\Iblock\Iblock::wakeUp(22)->getEntityDataClass();

        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete()
                ->configureNullable(false)
            ,
            (new DatetimeField('START_DATETIME'))
                ->configureRequired()
                ->addValidator(new DateValidator())
            ,
            (new DateTimeField('END_DATETIME'))
                ->configureRequired()
                ->addValidator(new DateValidator())
            ,
            //связь с инфоблоком Участники
            (new IntegerField('SPEAKER_ID'))
            ->configureNullable()
            ,
            (new Reference(
                'SPEAKER',
                $speakerIblockClass, 
                Join::on('this.SPEAKER_ID', 'ref.ID')
            ))
                ->configureJoinType(Join::TYPE_LEFT)
            ,
            //свойства инфоблока
            (new Reference(
                'SPEAKER_PROP',
                ConfSpeakersPropertyValuesTable::class,
                Join::on('this.SPEAKER_ID', 'ref.IBLOCK_ELEMENT_ID')
            ))
                ->configureJoinType(Join::TYPE_LEFT)
            ,
            //связь с инфоблокоа Аудитории
            (new IntegerField('ROOM_ID'))
                ->configureNullable()
            ,
            (new Reference(
                'ROOM',
                $roomIblockClass, 
                Join::on('this.ROOM_ID', 'ref.ID')
            ))
                ->configureJoinType(Join::TYPE_LEFT)
            ,
            //связь с инфоблоком конференции
            (new IntegerField('CONF_ID'))
                ->configureRequired()
            ,
            (new Reference(
                'CONF',
                $confIblockClass,
                Join::on('this.CONF_ID', 'ref.ID')
            ))
                ->configureJoinType(Join::TYPE_INNER)
            ,
            (new StringField('TOPIC'))
                ->configureSize(256)
                ->configureDefaultValue('')
            ,
        ];
    }

    public static function isCacheable(): bool
    {
        return true;
    }
}

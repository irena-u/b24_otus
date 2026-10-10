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
    /**
     * Имя таблицы
     *
     * @return void
     */
    public static function getDBTableName()
    {
        return 'conf_schedule';
    }

    /**
     * Имя соединения с БД
     *
     * @return void
     */
    public static function getConnectionName()
    {
        return 'default';
    }

    /**
     * Метод для создания таблицы
     *
     * @return void
     */
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

    /**
     * Метод для удаления таблицы
     *
     * @return void
     */
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


    /**
     * Основной метод ORM для описания полей таблицы и связей с инфоблоками
     *
     * @return void
     */
    public static function getMap()
    {
        //получаем классы инфоблоков
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
            //связь с инфоблоком Аудитории
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

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
            (new IntegerField('SPEAKER_ID'))
            ->configureNullable()
            , 
            (new Reference(
				'SPEAKER',
				ConfSpeakersPropertyValuesTable::class,
				Join::on('this.SPEAKER_ID', 'ref.ID')
			))
				->configureJoinType(Join::TYPE_LEFT)
			,
            (new StringField('TOPIC'))
                ->configureSize(256)
                ->configureDefaultValue('')
            ,
        ];
    }

    // public static function isCacheable(): bool
    // {
    //     return true;
    // }
}

<?php

namespace Otus\Currency\Models;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

/**
 * Class CurrencyTable
 *
 * Fields:
 * <ul>
 * <li> CURRENCY string(3) mandatory
 * <li> AMOUNT_CNT int optional default 1
 * <li> AMOUNT double optional
 * <li> SORT int optional default 100
 * <li> DATE_UPDATE datetime mandatory
 * <li> NUMCODE string(3) optional
 * <li> BASE bool ('N', 'Y') optional default 'N'
 * <li> CREATED_BY int optional
 * <li> DATE_CREATE datetime optional
 * <li> MODIFIED_BY int optional
 * <li> CURRENT_BASE_RATE double optional
 * </ul>
 *
 * @package Bitrix\Otus
 **/

class CurrencyTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_otus_currency';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new StringField(
                'CURRENCY',
                [
                    'primary' => true,
                    'validation' => function () {
                        return[
                            new LengthValidator(null, 3),
                        ];
                    },
                    'title' => Loc::getMessage('CURRENCY_ENTITY_CURRENCY_FIELD'),
                ]
            ),
            new IntegerField(
                'AMOUNT_CNT',
                [
                    'default' => 1,
                    'title' => Loc::getMessage('CURRENCY_ENTITY_AMOUNT_CNT_FIELD'),
                ]
            ),
            new FloatField(
                'AMOUNT',
                [
                    'title' => Loc::getMessage('CURRENCY_ENTITY_AMOUNT_FIELD'),
                ]
            ),
            new IntegerField(
                'SORT',
                [
                    'default' => 100,
                    'title' => Loc::getMessage('CURRENCY_ENTITY_SORT_FIELD'),
                ]
            ),
            new DatetimeField(
                'DATE_UPDATE',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CURRENCY_ENTITY_DATE_UPDATE_FIELD'),
                ]
            ),
            new StringField(
                'NUMCODE',
                [
                    'validation' => function () {
                        return[
                            new LengthValidator(null, 3),
                        ];
                    },
                    'title' => Loc::getMessage('CURRENCY_ENTITY_NUMCODE_FIELD'),
                ]
            ),
            new BooleanField(
                'BASE',
                [
                    'values' => ['N', 'Y'],
                    'default' => 'N',
                    'title' => Loc::getMessage('CURRENCY_ENTITY_BASE_FIELD'),
                ]
            ),
            new IntegerField(
                'CREATED_BY',
                [
                    'title' => Loc::getMessage('CURRENCY_ENTITY_CREATED_BY_FIELD'),
                ]
            ),
            new DatetimeField(
                'DATE_CREATE',
                [
                    'title' => Loc::getMessage('CURRENCY_ENTITY_DATE_CREATE_FIELD'),
                ]
            ),
            new IntegerField(
                'MODIFIED_BY',
                [
                    'title' => Loc::getMessage('CURRENCY_ENTITY_MODIFIED_BY_FIELD'),
                ]
            ),
            new FloatField(
                'CURRENT_BASE_RATE',
                [
                    'title' => Loc::getMessage('CURRENCY_ENTITY_CURRENT_BASE_RATE_FIELD'),
                ]
            ),
        ];
    }
}

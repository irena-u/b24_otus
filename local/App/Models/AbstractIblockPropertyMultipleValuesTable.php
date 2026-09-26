<?php

namespace App\Models;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;

abstract class AbstractIblockPropertyMultipleValuesTable extends DataManager
{
    public const IBLOCK_ID = null;

    public static function getTableName(): string
    {
        return 'b_iblock_element_prop_m' . static::IBLOCK_ID;
    }

    public static function getMap(): array
    {
        return [
            'ID'                => new IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            'IBLOCK_ELEMENT_ID' => new IntegerField('IBLOCK_ELEMENT_ID'),
            'IBLOCK_PROPERTY_ID' => new IntegerField('IBLOCK_PROPERTY_ID'),
            'VALUE'             => new StringField('VALUE'),
            'VALUE_ENUM'        => new IntegerField('VALUE_ENUM'),
            'VALUE_NUM'         => new StringField('VALUE_NUM'),
            'DESCRIPTION'       => new StringField('DESCRIPTION'),
        ];
    }
}

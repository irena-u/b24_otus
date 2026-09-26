<?php

namespace App\Models\Lists;

use Bitrix\Main\Entity\ReferenceField;
use App\Models\AbstractIblockPropertyValuesTable;

class DoctorsPropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    public const IBLOCK_ID = 16;

    public static function getMap(): array
    {
        $map = parent::getMap();
        $map['SERVICES'] = new ReferenceField(
                'SERVICES',
                \App\Models\Lists\DoctorsServicesPropertyValuesTable::class,
                ['=this.SERVICES|SINGLE.VALUE' => 'ref.IBLOCK_ELEMENT_ID']
            );

        return $map;

    }
}

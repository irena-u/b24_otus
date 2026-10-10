<?php

namespace App\Models\Lists;

use App\Models\AbstractIblockPropertyValuesTable;

class ConfSpeakersPropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    const IBLOCK_ID = 20;
    public static function getMap(): array
    {
        $map = parent::getMap();

        return $map;

    }
}
<?php

namespace Otus\Currency;

use Otus\Currency\Models\CurrencyTable;

class Currency
{
    /**
     * Получает список валют
     *
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public static function getCurrencyList($page = 1, $limit = 0): array
    {
        $offset = $limit * ($page - 1);
        $list = [];
        $data = CurrencyTable::getList([
            'select' => ['CURRENCY','SORT','AMOUNT', 'BASE', 'AMOUNT_CNT', 'DATE_UPDATE', 'CREATED_BY','NUMCODE', 'DATE_CREATE', 'MODIFIED_BY'],
            'order' => ['SORT' => 'ASC', 'CURRENCY' => 'ASC'],
            'limit' => $limit,
            'offset' => $offset
        ]);

        while ($item = $data->fetch()) {
            $list[$item['CURRENCY']]['data'] = $item;
        }

        return $list;
    }

    public function getColumn()
    {
        $arDefaultColumns = ['CURRENCY','SORT','AMOUNT', 'BASE'];
        $fieldMap = CurrencyTable::getMap();
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            if ($field->getTitle()) {
                $columns[] = array(
                    'id' => $field->getName(),
                    'name' => $field->getTitle(),
                    'default' => (in_array($field->getName(), $arDefaultColumns)) ? true : false,
                );
            }
        }
        return $columns;
    }

}

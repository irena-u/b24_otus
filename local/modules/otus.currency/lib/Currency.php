<?php
namespace Otus\Currency;

use Otus\Currency\Models\CurrencyTable; 

class Currency {
    /**
     * Получает список валют
     *
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public static function getCurrencyList($page = 1, $limit = 0):array {
        $offset = $limit * ($page-1);
        $list = [];
        $data = CurrencyTable::getList([
            'select' => ['CURRENCY','SORT','AMOUNT', 'BASE'],
            'order' => ['SORT' => 'ASC', 'CURRENCY' => 'ASC'],
            'limit' => $limit,
            'offset' =>$offset
        ]);
        
        while ($item = $data->fetch()) {
            $list[$item['CURRENCY']] = $item;
        }

        return $list;
    }
}

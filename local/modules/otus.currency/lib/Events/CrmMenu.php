<?php

namespace Otus\Currency\Events;

use Bitrix\Main\EventResult;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use \Bitrix\Main\Config\Option;

class CrmMenu
{
    /** Функция для обработчика события onEntityDetailsTabsInitialized
     * отрисовка табов в CRM
     *
     * @param \Bitrix\Main\Event $event
     * @return EventResult
     */
    public static function getTab(\Bitrix\Main\Event $event): EventResult
    {
        $entityId = $event->getParameter('entityID');
        $entityTypeID = $event->getParameter('entityTypeID');
        $tabs = $event->getParameter('tabs');

        switch ($entityTypeID) {
            case \CCrmOwnerType::Company:
                $tabs = self::getCurrencies($tabs, $entityId);
                break;
        }

        return new EventResult(EventResult::SUCCESS, [
            'tabs' => $tabs,
        ]);
    }

    /**
     * Функция для добавления кастомного пункта меню в CRM
     *
     * @param array $tabs
     * @param integer $id
     * @return array
     */
    public static function getCurrencies(array $tabs, int $id): array
    {

        $tabs[] = [
           'id' => 'deals_currencies',
           'name' => Loc::getMessage('MENU_CURRENCIES'),
           'enabled' => !empty($id),
           'loader' => [
               'serviceUrl' => '/local/components/otus/otus.grid/ajax.php?&site=' . \SITE_ID . '&' . \bitrix_sessid_get(),
               'componentData' => [
                   'template' => '',
                   'params' => [
                       'GRID_ID' => 'currency_grid_id',
                       'FILTER_ID' => 'currency_grid_filter',
                        'SHOW_CHECKBOXES' => 'Y',
                        'nPageSize' => Option::get('otus.currency', 'pagesize', 5),
                        'FILTER' => $id
                   ]
               ]
           ]
       ];

        return $tabs;
    }
}

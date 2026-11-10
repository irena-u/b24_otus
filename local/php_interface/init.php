<?php

use Bitrix\Main\EventManager;
// composer
if (file_exists(__DIR__ . '/../../vendor/autoload.php'))
{
    require_once(__DIR__ . '/../../vendor/autoload.php');
}

// App
if (file_exists(__DIR__ . '/../App/autoload.php'))
{
    require_once(__DIR__ . '/../App/autoload.php');
}

EventManager::getInstance()->addEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [\App\UserTypes\CIBlockPropertyServicesNote::class, 'GetUserTypeDescription']
);

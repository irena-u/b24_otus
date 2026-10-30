<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\ORM;
use Bitrix\Main\IO\Directory;

class otus_currency extends \CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'otus.currency';
        $this->MODULE_NAME = Loc::getMessage('OTUS_CURRENCY_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('OTUS_URRENCY_DESCRIPTION');

        require __DIR__ . '/version.php';

        if (isset($arModuleVersion['VERSION'])) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        }

        if (isset($arModuleVersion['VERSION_DATE'])) {
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
    }

    public function DoInstall()
    {
        global $USER;

        /**
         * @var \CUser $USER
         */

        if (!$USER->IsAdmin()) {
            return;
        }

        ModuleManager::registerModule($this->MODULE_ID);

        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();
        $this->InstallTasks();
    }

    public function DoUninstall()
    {
        global $USER;

        /**
         * @var \CUser $USER
         */

        if (!$USER->IsAdmin()) {
            return;
        }

        $this->UnInstallDB();
        $this->UnInstallTasks();
        $this->UnInstallEvents();
        $this->UnInstallFiles();

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallDB()
    {
        global $DB, $APPLICATION;
        $connection = \Bitrix\Main\Application::getConnection();
        $errors = null;

        if (!$DB->TableExists('b_otus_currency')) {
            $errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID. '/install/' . $connection->getType() . '/install.sql');
        }
        $GLOBALS["errors"] = $this->errors;
        // установка событий
        // EventManager::getInstance()->registerEventHandler(...);

        // установка агентов
        // CAgent::AddAgent(...);

        return true;
    }

    public function InstallEvents()
    {
        // установка почтовых и СМС шаблонов
        // $type = new CEventType;
        // $type->Add(...);
    }

    public function InstallFiles()
    {
        // установка файлов
        // CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . "/local/modules/{$this->MODULE_ID}/install/admin", $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . "/local/modules/{$this->MODULE_ID}/install/components/otus/", $_SERVER['DOCUMENT_ROOT'] . '/local/components/otus/', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . "/local/modules/{$this->MODULE_ID}/install/public/", $_SERVER['DOCUMENT_ROOT'], true, true);
    }

    public function UnInstallDB()
    {
        global $DB, $APPLICATION;
        $connection = \Bitrix\Main\Application::getConnection();
        $errors = null;
        if ($DB->TableExists('b_otus_currency')) {
            $errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID. '/install/' . $connection->getType() . '/uninstall.sql');
        }
        $GLOBALS["errors"] = $this->errors;
    }
    public function UnInstallFiles()
    {
        // удаление директорий
        Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . '/local/components/otus/otus.grid/');
        Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . '/currency/');
    }
}

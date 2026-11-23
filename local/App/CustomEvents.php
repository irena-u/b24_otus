<?php
namespace App;

class CustomEvents
{
    public static function OnProlog()
    {
        global $USER;
        $arJsConfig = array(
            'custom_start' => array(
                'js' => '/local/js_libs/custom_start/main.js',
                //'css' => '/local/js_libs/custom_start/main.css',
                'rel' => array("ui.dialogs.messagebox","popup")
            )
        );
        foreach ($arJsConfig as $ext => $arExt) {
            \CJSCore::RegisterExt($ext, $arExt);
        }
        \CUtil::InitJSCore(array('custom_start'));

        //CJSCore::Init(array('jquery', 'ajax', 'popup'));

        //$asset = \Bitrix\Main\Page\Asset::getInstance();

        //$settings=[];

       // if (preg_match('/\/crm.*/', GetPagePath())) {
       //    $asset->addString('<script>BX.ready(function () { Dreamsite.crm(' . CUtil::PhpToJSObject($settings) . '); });</script>');
       // }

        //if (preg_match('/\/crm\/company\/details\/.*/', GetPagePath())) {
            //$asset->addString('<link rel="stylesheet" type="text/css" href="/local/js/dreamsite/datatables/datatables.min.css"/><script type="text/javascript" src="/local/js/dreamsite/datatables/datatables.min.js"></script>');
           // $asset->addString('<script>BX.ready(function () { Custom.crmCompany(); });</script>');
        //}

        //На всех страницах
        //$asset->addString('<script>BX.ready(function () { Dreamsite.all(); });</script>');
    }


    public static function OnBeforePrologHandler()
    {
        //\CJSCore::Init(array('jquery2'));

    }

}
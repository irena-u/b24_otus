<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
 
Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);
$MOD_RIGHT = $APPLICATION->GetGroupRight($module_id);

$arTabs = array(
     array(
        "DIV"           => "edit",
        "TAB"           => Loc::GetMessage('OTUS_CURRENCY_SETTINGS'),//'Настройки',
        "TITLE"         => Loc::GetMessage('OTUS_CURRENCY_MODULE_SETTINGS'),//'Настройки параметров модуля',
        "OPTIONS"       => array(
            Loc::GetMessage('OTUS_CURRENCY_OPTIONS_TITLE'),//'Настройки таблицы',
            array(
                "pagesize",
                Loc::GetMessage('OTUS_CURRENCY_OPTIONS_PAGESIZE'),//'Количество записей на странице',
                Option::get($module_id, 'pagesize', '5'),
                array("text",3)
            ),
        )
    )    
);

$tabControl = new CAdminTabControl(
    "tabControl",
   $arTabs
  );

$tabControl->Begin();

if($request->isPost() && check_bitrix_sessid()){

    foreach($arTabs as $arTab){

       foreach($arTab["OPTIONS"] as $arOption){

           if(!is_array($arOption)){

               continue;
           }

           if($arOption["note"]){

                continue;
           }

           if($request["apply"]){

                $optionValue = $request->getPost($arOption[0]);
                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            }elseif($request["default"]){

                Option::set($module_id, $arOption[0], $arOption[2]);
            }
       }
    }

    LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
    }

?>
  <form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

  <?
   foreach($arTabs as $i=>$arTab){
    $tabControl->BeginNextTab();
    if($arTabs[$i]["OPTIONS"]){
         __AdmSettingsDrawList($module_id, $arTabs[$i]["OPTIONS"]);
    } 
  }    
   
    $tabControl->Buttons();
  ?>

   <input type="submit" <?if ($MOD_RIGHT<"W") echo "disabled" ?> name="apply" value="Сохранить" class="adm-btn-save" />
    <input type="submit"  name="default" value="Отменить" />

   <?
   echo(bitrix_sessid_post());
 ?>
</form>
<?
 $tabControl->End();
?>
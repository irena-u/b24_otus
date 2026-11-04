<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */

$arComponentParameters = array(
    "GROUPS" => array(
        "LIST" => array(
            "NAME" => GetMessage("GRID_PARAMETERS"),
            "SORT" => "300"
        )
    ),
    "PARAMETERS" => array(
        "SHOW_CHECKBOXES" =>  array(
            "PARENT" => "LIST",
            "NAME" => GetMessage("SHOW_ACTION_BTNS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N"
        ),
        "nPageSize" =>  array(
            "PARENT" => "LIST",
            "NAME" => GetMessage("NUM_PAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => "20"
        )
    )
);

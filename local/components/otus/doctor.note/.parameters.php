<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
		"LIST"=>array(
			"NAME"=>GetMessage("VIEW_PARAMETERS"),
			"SORT"=>"300"
		)
	),
	"PARAMETERS" => array(
		"SERVICE_ID" =>  array(
			"PARENT" => "LIST",
			"NAME"=>GetMessage("SERVICE"),
			"TYPE"=>"STRING",
			"DEFAULT" => "39"
		),
		"DOCTOR_ID" =>  array(
			"PARENT" => "LIST",
			"NAME"=>GetMessage("SERVICE"),
			"TYPE"=>"STRING",
			"DEFAULT" => "49"
		),
	)
);

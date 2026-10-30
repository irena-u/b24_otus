<?php

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */
 
$APPLICATION->SetTitle(Loc::getMessage('OTUS_GRID_TITLE'));

// load your js extension (https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=12435)
//Extension::load('otus.grid');

?>

<div id="otus-grid" class="otus-grid"></div>

<!-- Example -->
Example of using params:<br>
Safe: <?= $arParams['USERNAME'] ?> and <?= htmlspecialcharsbx($arParams['~USERNAME']) ?>

<script>
BX.ready(() => {
	const container = document.getElementById('otus-grid');
	const fruits = <?= Json::encode($arResult['FRUITS']) ?>;

	// render extension inside container
	// new BX.Otus.Grid({
	// 	container,
	// 	fruits,
	// });
});
</script>

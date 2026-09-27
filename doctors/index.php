<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;
use App\Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use App\Models\Lists\DoctorsServicesPropertyValuesTable as DoctorsServicesTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Врачи");
Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
\Bitrix\Main\UI\Extension::load("ui.forms");
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$page = $request->get('page') ?? '';
$action = $request->get('action') ?? '';

$arDoctors = [];
$arServices = [];

    //список процедур
    $dbServices = DoctorsServicesTable::getList([
        'select' => [
            'ID' => 'IBLOCK_ELEMENT_ID',
            'NAME' => 'ELEMENT.NAME',
        ]
    ]);
    if ($dbServices) {
        while($arItem = $dbServices->fetch()) {
            $arServices[$arItem['ID']] = $arItem['NAME'];
        }
    }
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/doctors/">Клиника</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainMenu"
                aria-controls="mainMenu"
                aria-expanded="false"
                aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= (empty($page)) ? 'active' : '' ?>"
                       href="/doctors/">
                        Список врачей
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'services' ? 'active' : '' ?>"
                       href="/doctors/?page=services">
                        Список процедур
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'summary' ? 'active' : '' ?>"
                       href="/doctors/?page=summary">
                        Врачи и процедуры
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?
if (!$page && !$action) {
    //список врачей
    // получаем список записей из инфоблока Врачи в виде массива

    $dbDoctors = DoctorsTable::getList([
        'select' => [
            'ID' => 'IBLOCK_ELEMENT_ID',
            'NAME' => 'ELEMENT.NAME',
            'LAST_NAME' => 'LAST_NAME',
            'FIRST_NAME' => 'FIRST_NAME',
            'SECOND_NAME' => 'SECOND_NAME',
        ]
    ]);
    if ($dbDoctors) {
        $arDoctors = $dbDoctors->fetchAll();
    }

    if (!empty($arDoctors)) {?>
    <a class="ui-btn ui-btn-default" href="/doctors/?action=add">Добавить</a>
    <div class="container py-4">
        <h2 class="mb-4">Список врачей</h2>

        <div class="row g-4">
            <?php foreach ($arDoctors as $doctor): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="/doctors/index.php?page=<?= htmlspecialchars($doctor['NAME']) ?>" 
                    class="card h-100 text-decoration-none shadow-sm doctor-card">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">
                                <?= htmlspecialchars($doctor['LAST_NAME']) ?>
                            </h5>
                            <p class="card-text text-muted mb-0">
                                <?= htmlspecialchars($doctor['FIRST_NAME'] . ' ' . $doctor['SECOND_NAME'])?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    }
} elseif ($page == 'summary') {
    //врачи и процедуры
    // получаем список записей из инфоблока Врачи в виде массива

    $dbDoctors = DoctorsTable::query()
    ->setSelect([
        '*',
        'NAME' => 'ELEMENT.NAME',
        'SERVICES_NAME' => 'SERVICES.ELEMENT.NAME', 
    ])
    ->setOrder(['LAST_NAME' => 'asc'])
    ->exec();

    if ($dbDoctors) {
        $arDoctors = $dbDoctors->fetchAll();
    }
    
    $arResult = [];
    foreach($arDoctors as $i=> $doctor) {
            $arResult[$doctor['IBLOCK_ELEMENT_ID']]['NAME'] = $doctor['NAME'];
            $arResult[$doctor['IBLOCK_ELEMENT_ID']]['LAST_NAME'] = $doctor['LAST_NAME'];
            $arResult[$doctor['IBLOCK_ELEMENT_ID']]['FIRST_NAME'] = $doctor['FIRST_NAME'];
            $arResult[$doctor['IBLOCK_ELEMENT_ID']]['SECOND_NAME'] = $doctor['SECOND_NAME'];
            $arResult[$doctor['IBLOCK_ELEMENT_ID']]['SERVICES'][] = $doctor['SERVICES_NAME'];
    }
    ?>
    <a class="ui-btn ui-btn-default" href="/doctors/?action=add">Добавить</a>
    <div class="container py-4">
        <h2 class="mb-4">Список врачей</h2>

        <div class="row g-4">
            <?php foreach ($arResult as $doctor): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="/doctors/index.php?page=<?= htmlspecialchars($doctor['NAME']) ?>" 
                    class="card h-100 text-decoration-none shadow-sm doctor-card">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">
                                <?= htmlspecialchars($doctor['LAST_NAME'].' '.$doctor['FIRST_NAME'] . ' ' . $doctor['SECOND_NAME']); ?>
                            </h5>
                            <p class="card-text text-muted mb-0">
                                <ul class="list-group">
                                <?foreach($doctor['SERVICES'] as $item):?>
                                    <li class="list-group-item"><?= $item;?></li>
                                <?endforeach;?>
                                </ul>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?
} elseif ($page == 'services') {
    ?>
    <a class="ui-btn ui-btn-default" href="/doctors/?action=addservice">Добавить</a>
    <div class="container py-4">
    <h2 class="mb-4">Список процедур</h2>

    <div class="row g-1">
        <?php foreach ($arServices as $service): ?>
                <ul class="list-group">
                    <li class="list-group-item"><?= $service ?></li>
                </ul>
        <?php endforeach; ?>
    </div>
    </div>
    <?php
} elseif (!$page && $action == 'add') {
    ?>
    <h2>Добавление врача</h2>

    <?
    $fields = $request->getPostList()->toArray(); 

    if (check_bitrix_sessid() && !empty($fields) ) {
        //Добавляем элемент в инфоблок
        $result = DoctorsTable::add($fields);
        if ($result) {
            unset($_POST);
            echo '<p>Доктор добавлен. Перейти на страницу <a href="/doctors/">Врачи</a></p>';
        }
    } else {
    //показываем форму добавления врача
    ?>
    <form method="post">
        <?= bitrix_sessid_post() ?>
    
    <div class="ui-form">
            <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Название страницы (латиницей)</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w25">
                <input type="text" name="NAME" class="ui-ctl-element" required placeholder="Название страницы">
            </div>
        </div>
    </div>
    <!-- Фамилия -->
    <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Фамилия</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w25">
                <input type="text" name="LAST_NAME" class="ui-ctl-element" required placeholder="Фамилия">
            </div>
        </div>
    </div>

    <!-- Имя -->
    <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Имя</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w25">
                <input type="text" name="FIRST_NAME" class="ui-ctl-element" required placeholder="Имя">
            </div>
        </div>
    </div>

    <!-- Отчество -->
    <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Отчество</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w25">
                <input type="text" name="SECOND_NAME" class="ui-ctl-element" required placeholder="Отчество">
            </div>
        </div>
    </div>

    <!-- Процедуры (множественный select) -->
    <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Процедуры</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-multiple-select ui-ctl-w25">
                <select name="SERVICES[]" multiple required class="ui-ctl-element" size="5">
                    <?php
                    foreach($arServices as $i => $item) { 
                        echo "<option value=".$i.">".$item."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Кнопка Сохранить -->
    <div class="ui-form-row">
        <div class="ui-form-content">
            <button type="submit" class="ui-btn ui-btn-success">Сохранить</button>
        </div>
    </div>
    </div>
    </form>
    <?php
    }
} elseif (!$page && $action == 'addservice') {
    ?>
    <h2>Добавление процедуры</h2>

    <?php
    $fields = $request->getPostList()->toArray(); 

    if (check_bitrix_sessid() && !empty($fields) ) {
        //Добавляем элемент в инфоблок
        $result = DoctorsServicesTable::add($fields);
        if ($result) {
        unset($_POST);
        echo '<p>Процедура добавлена. Перейти на страницу <a href="/doctors/?page=services">Процедуры</a></p>';
        }
    } else {
    //показываем форму добавления процедуры
    ?>
    <form method="post">
        <?= bitrix_sessid_post() ?>
    
    <div class="ui-form">
            <div class="ui-form-row">
        <div class="ui-form-label">
            <div class="ui-ctl-label-text">Название</div>
        </div>
        <div class="ui-form-content">
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w25">
                <input type="text" name="NAME" class="ui-ctl-element" required placeholder="Название">
            </div>
        </div>
    </div>

    <!-- Кнопка Сохранить -->
    <div class="ui-form-row">
        <div class="ui-form-content">
            <button type="submit" class="ui-btn ui-btn-success">Сохранить</button>
        </div>
    </div>
    </div>
    </form>

    <?php
    }
} else {
    //страница врача
    $dbDoctors = DoctorsTable::query()
    ->setSelect([
        '*',
        'ID' => 'ELEMENT.ID',
        'NAME' => 'ELEMENT.NAME',
        'SERVICES_ID' => 'SERVICES.ELEMENT.ID',
        'SERVICES_NAME' => 'SERVICES.ELEMENT.NAME', 
    ])
    ->setOrder(['LAST_NAME' => 'asc'])
    ->where('NAME', htmlspecialchars($page))
    ->exec();

    if ($dbDoctors) {
        $arDoctors = $dbDoctors->fetchAll();
    } else {
        echo "<p>Доктор не найден</p>";
    }

    $arResult = [];
    foreach($arDoctors as $i=> $doctor) {
            $arResult = [
                'ID'          => $doctor['ID'],
                'NAME'        => $doctor['NAME'] ?? 'newvalue',
                'LAST_NAME'   => $doctor['LAST_NAME']   ?? '',
                'FIRST_NAME'  => $doctor['FIRST_NAME']  ?? '',
                'SECOND_NAME' => $doctor['SECOND_NAME'] ?? '',
            ];
            if (array_key_exists('SERVICES_NAME', $doctor)) {
                $arResult['SERVICES'][$doctor['SERVICES_ID']] = $doctor['SERVICES_NAME'];
            }
    }

    ?>
        <h2><?= $arResult['LAST_NAME'].' '. $arResult['FIRST_NAME']. ' '. $arResult['SECOND_NAME']?></h3>
        <ul>
        <?
        foreach($arResult['SERVICES'] as $i => $item) {
            echo "<li>{$item}</li>";
        }
        ?>
        </ul>
    <?php
}
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
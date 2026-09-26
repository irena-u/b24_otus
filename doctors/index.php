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

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$page = $request->get('page') ?? '';

$arDoctors = [];
$arServices = [];
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
if (!$page) {
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

    //print_r(sage($arDoctors));
    ?>
    <?php
        if (!empty($arDoctors)) {?>

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
} elseif ($page == 'services') {
    //список процедур
    $dbServices = DoctorsServicesTable::getList([
        'select' => [
            'ID' => 'IBLOCK_ELEMENT_ID',
            'NAME' => 'ELEMENT.NAME',
        ]
    ]);
    if ($dbServices) {
        $arServices = $dbServices->fetchAll();
    }

    //print_r(sage($arServices));
?>
    <div class="container py-4">
    <h2 class="mb-4">Список процедур</h2>

    <div class="row g-1">
        <?php foreach ($arServices as $service): ?>
                <ul class="list-group">
                    <li class="list-group-item"><?= htmlspecialchars($service['NAME']) ?></li>
                </ul>
        <?php endforeach; ?>
    </div>
</div>
<?php

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
    print_r($arDoctors);
    print_r(sage($arDoctors));

} else {
    //страница врача
    
    $dbDoctors = DoctorsTable::query()
    ->setSelect([
        '*',
        'NAME' => 'ELEMENT.NAME',
        'SERVICES_NAME' => 'SERVICES.ELEMENT.NAME', 
    ])
    ->setOrder(['LAST_NAME' => 'asc'])
    ->where('NAME', htmlspecialchars($page))
    ->exec();

    if ($dbDoctors) {
        $arDoctors = $dbDoctors->fetchAll();
    }

    print_r(sage($arDoctors));

}
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
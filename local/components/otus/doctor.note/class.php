<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Loader;
use App\Debug\Log;
use Bitrix\Main\SystemException;
use Bitrix\Main\Application;
use App\Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use App\Models\Lists\DoctorsServicesPropertyValuesTable as DoctorsServicesTable;
use App\Models\Lists\DoctorsNotesPropertyValuesTable as DoctorsNotesTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;

class DoctorNoteComponent extends CBitrixComponent implements Controllerable
{
    protected function getDefaultPreFilters()
    {
        return [
            new Bitrix\Main\Engine\ActionFilter\Authentication(),
            new Bitrix\Main\Engine\ActionFilter\HttpMethod(
                [
                    Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_POST
                ]
            ),
            new Bitrix\Main\Engine\ActionFilter\Csrf(),
        ];
    }

    public function configureActions(): array
    {
        return [
            'getform' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST,
                    ]),
                    new ActionFilter\Csrf(),
                ],
            ],
            'addnote' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST,
                    ]),
                    new ActionFilter\Csrf(),
                ],
            ],
        ];
    }

    /**
     * Получает название процедуры
     *
     * @param integer $id
     * @return string
     */
    public function getServiceName(int $id):string {
        if (!Loader::includeModule('iblock')) {
            return "";
        }
        $str = '';

        $dbServices = DoctorsServicesTable::query()
        ->setSelect([
            'NAME' => 'ELEMENT.NAME',
            'ID' => 'IBLOCK_ELEMENT_ID',
        ])
        ->where('ID', htmlspecialchars($id))
        ->setLimit(1)
        ->exec();

        if ($dbServices) {
            $arService = $dbServices->fetch();
            $str = $arService['NAME'];
        }
        return $str;
    }

    /**
     * Получает ФИО врача
     *
     * @param integer $id
     * @return string
     */
    public function getDoctorName(int $id):string {
        if (!Loader::includeModule('iblock')) {
            return "";
        }
        $str = '';

        $dbDoctors = DoctorsTable::query()
        ->setSelect([
            'LAST_NAME' => 'LAST_NAME',
            'FIRST_NAME' => 'FIRST_NAME',
            'SECOND_NAME' => 'SECOND_NAME',
            'ID' => 'IBLOCK_ELEMENT_ID',
        ])
        ->where('ID', htmlspecialchars($id))
        ->setLimit(1)
        ->exec();

        if ($dbDoctors) {
            $arDoctor = $dbDoctors->fetch();
            $str = $arDoctor['LAST_NAME'].' '. mb_substr($arDoctor['FIRST_NAME'],0,1). '.'. mb_substr($arDoctor['SECOND_NAME'],0,1).'.';
        }
        return $str;
    }

    public function getformAction(int $id = 0, int $doctor_id = 0)
    {
        $doctorId = $doctor_id;
        //$arNotes = $this->getNotesList($doctorId);
        $doctorName = $this->getDoctorName($doctorId);
        $serviceName = $this->getServiceName($id);

        $savedResult = $this->arResult;          // сохранили, что было
        $this->arParams = [
            'SERVICE_ID'=> $id,
            'DOCTOR_ID' => $doctorId,
        ];
        $this->arResult = [
            //'NOTES' => $arNotes,
            'DOCTOR_NAME' => $doctorName,
            'SERVICE_NAME' => $serviceName,
        ];

        ob_start();
        $this->includeComponentTemplate(); // templates/.default
        $html = ob_get_clean();

        $this->arResult = $savedResult;          // вернули как было
        return $html;
        
    }

    public function addnoteAction($fio,$service_id,$doctor_id,$service_date) {
        if (!Loader::includeModule('iblock')) {
            return "";
        }

        $fields = [
            'NAME' => $fio,
            'SERVICE_ID' => $service_id,
            'DOCTOR_ID' => $doctor_id,
            'SERVICE_DATE'  => $service_date,
        ];
        if (check_bitrix_sessid() && !empty($fields) ) {
        //Добавляем элемент в инфоблок
            $result = DoctorsNotesTable::add($fields);
            if ($result) {
                //unset($_POST);
                return '<p>Запись добавлена.</p>';
            }
        }
    }

    public function onPrepareComponentParams($arParams): array
    {
        // TODO: prepare or format component params
        $arParams['SERVICE_ID'] ??= '0';
        $arParams['DOCTOR_ID'] ??= '0';

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->prepareResult();

        $this->includeComponentTemplate();
    }

    private function prepareResult(): void
    {
        // TODO: prepare result for template.php
        $this->arResult['SERVICE'] = [
            'ID'	=> 'id',
            'NAME' => 'name',
            'DOCTOR' => 'doctor',
        ];
    }
}

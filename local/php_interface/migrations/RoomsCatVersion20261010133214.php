<?php

namespace Sprint\Migration;


class RoomsCatVersion20261010133214 extends Version
{
    protected $author = "admin";

    protected $description = "";

    protected $moduleVersion = "5.15.0";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'room',
            'lists'
        );

        $helper->Iblock()->saveSectionsFromTree(
            $iblockId,
            array (
  0 => 
  array (
    'NAME' => 'Корпус 1',
    'CODE' => NULL,
    'SORT' => '500',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'PICTURE' => NULL,
    'DESCRIPTION' => NULL,
    'DESCRIPTION_TYPE' => 'text',
    'DETAIL_PICTURE' => NULL,
  ),
  1 => 
  array (
    'NAME' => 'Корпус 2',
    'CODE' => NULL,
    'SORT' => '500',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'PICTURE' => NULL,
    'DESCRIPTION' => NULL,
    'DESCRIPTION_TYPE' => 'text',
    'DETAIL_PICTURE' => NULL,
  ),
)        );
    }
}

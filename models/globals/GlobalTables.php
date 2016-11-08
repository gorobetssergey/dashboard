<?php

namespace app\models\globals;

use app\models\ItemsTransport;
use app\models\PropertiesGroup;
use app\models\TransportProp;
use yii\bootstrap\Modal;
use app\models\Submenu;
use yii\db\Query;

class GlobalTables extends Modal
{
    private $table;//table a specific directory return model of this table
    private $catalog;//number of catalog
    private $topmenu;
    private $submenu;
    private $properties;//all properties specific catalog
    private $table_properties;//table a specific directory property
    private $view;//specific view of items
    private $scenaries;

    /**
     * return views specific of items
     */
    const VIEWS = [
      '1' => 'transport/tires'
    ];
    /**
     * return specific scenario
     */
    const SCENARIES = [
      '1' => 'transport_tires'
    ];
    /**
     * link of topmenu
     */
    const TRANSPORT = 1;
    /**
     * link of catalog
     */
    const TIRES = 1;

    public function __construct(array $config = [])
    {
        $this->catalog = $config['catalog'];
        if($this->catalog)
        {
            return $this->setParams();
        }
    }

    private function setParams()
    {
        switch($this->catalog)
        {
            case self::TIRES :
                                    $this->topmenu = self::TRANSPORT;
                                    $this->table = new ItemsTransport();
                                    $this->table_properties = 'transport_prop';
                                    $this->properties = (new PropertiesGroup($this->catalog))->getAllProp();
                                    $this->view = self::VIEWS[$this->catalog];
                                    $this->scenaries = self::SCENARIES[$this->catalog];
        }
    }


    public function getParams()
    {
        $params = [
            'properties' => $this->properties,
            'table' => $this->table,
            'topmenu' => $this->topmenu,
            'table_properties' => $this->table_properties,
            'scenario' =>  $this->scenaries,
            'view' => $this->view,
            'catalog' => $this->catalog
        ];

        return $params;
    }

    public function getModel($model,$id)
    {
        switch($model)
        {
            case self::TRANSPORT : return (ItemsTransport::find()->with(['transportProps'])->where(['id' => $id])->one());break;
        }
    }

    public function getItemsTable($top,$id_items)
    {
        switch($top)
        {
            case self::TRANSPORT :
                $this->table = ItemsTransport::findOne($id_items);break;
        }

        return [
            'itemsTable' => $this->table,
            'itemsName' => $this->table->getPropGroup()->with(['prop'])->orderBy(['id' => SORT_DESC])->one()->prop->getTransportProps()->orderBy(['id' => SORT_DESC])->one()->value
        ];
    }
}

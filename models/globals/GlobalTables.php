<?php

namespace app\models\globals;

use app\models\ItemsTransport;
use app\models\PropertiesGroup;
use app\models\TransportProp;
use yii\bootstrap\Modal;
use app\models\Submenu;

class GlobalTables extends Modal
{
    private $table;
    private $catalog;
    private $topmenu;
    private $submenu;
    private $properties;
    private $table_properties;

    const TRANSPORT = 1;

    public function __construct(array $config)
    {
        $this->catalog = $config['catalog'];
        $this->setParams();
    }

    private function setParams()
    {
        switch($this->catalog)
        {
            case self::TRANSPORT :
                                    $this->topmenu = 'transport';
                                    $this->table = self::TRANSPORT;
                                    $this->submenu = (new Submenu($this->catalog))->getSubmenu();
                                    $this->table_properties = 'TransportProp';//new TransportProp();
                                    $this->properties = (new PropertiesGroup($this->catalog))->getAllProp();
        }
    }

    public function getParams()
    {
        $params = [
            'properties' => $this->properties,
            'table' => $this->table,
            'topmenu' => $this->topmenu,
            'table_properties' => $this->table_properties,
            'submenu' => $this->submenu
        ];

        return $params;
    }
}
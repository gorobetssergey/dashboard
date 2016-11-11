<?php

namespace app\models\globals;

use app\models\ItemsTransport;
use app\models\PhotoTransport;
use app\models\PropertiesGroup;
use app\models\TransportProp;
use yii\bootstrap\Modal;
use app\models\Submenu;
use yii\db\Query;
use app\models\Moderation;
use app\models\Items;
use app\models\ModerationMistake;

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
    private $query;

    const TRANSPORTPROPS = 'transportProps';
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
        $this->catalog = (isset($config['catalog'])) ? $config['catalog'] : null;

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

    /**
     * @param $model - id tompenu
     */

    public function getTableProperties($model)
    {
        switch($model)
        {
            case self::TRANSPORT :
                                    $this->query = ItemsTransport::find();
                                    return self::TRANSPORTPROPS;break;
        }
    }

    /**
     * @param $model
     * @param $id
     * @param $user
     * @return array|null|\yii\db\ActiveRecord
     */
    private function getTablePropertiesModel($model,$id, $user)
    {
        if(!$user)
        {
            return ($this->query->with([$model])->where(['id' => $id])->one());
        }else{
            return ($this->query->with([$model])->where([
                'id' => $id,
                'user_id' => $user
            ])->one());
        }
    }

    /**
     * @param $model - id tompenu
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getModel($model,$id, $user = null)
    {
        switch($model)
        {
            case self::TRANSPORT : return $this->getTablePropertiesModel($this->getTableProperties($model),$id, $user);break;
        }
    }

    /**
     * @param $top
     * @param $id_items
     * @return array
     */
    public function getItemsTable($top,$id_items)
    {
        switch($top)
        {
            case self::TRANSPORT :
                $this->table = ItemsTransport::findOne($id_items);break;
        }

        return [
            'itemsTable' => $this->table,
            'itemsName' => $this->table->getPropGroup()
                ->with(['prop'])
                ->orderBy(['id' => SORT_DESC])->one()
                ->prop->getTransportProps()->where(['items_id'=>$this->table->id])
                ->orderBy(['id' => SORT_DESC])
                ->one()->value
        ];
    }
    
    public function getUserItemsInModeration($user)
    {
        $model = new Moderation();
        $itemsModeration = $model->getItemsModeration($user);

        $arr = [];

        foreach ($itemsModeration as $item) {
            $arr[] = $this->getModel($item->topmenu_id,$item->items_id);
        }
        return $arr;
    }
    
    public function getActivItems()
    {
        $active = new Items(['scenario' => 'get_self_active_items']);
        $itemsLive = $active->getItemsLive(1);
        $arr = [];

        foreach ($itemsLive as $item) {
            $arr[] = $this->getModel($item->topmenu_id,$item->items_id);
        }
        return $arr;
    }

    public function getMistakeItems()
    {
        $active = new ModerationMistake();
        $itemsModeration = $active->getItemsModeration(1);
        $arr = [];

        foreach ($itemsModeration as $item) {
            $arr[] = [
                'model' => $this->getModel($item->topmenu_id,$item->items_id),
                'name' => $item->descriptions
                ];
        }
        return $arr;
    }
    
    public function getPhoto($topmenu,$items)
    {
        $qery = [
            'topmenu_id'=>$topmenu,
            'item_id' =>$items
        ];

        switch ($topmenu)
        {
            case self::TRANSPORT : return [
                        (new PhotoTransport())->getPhoto($qery),
                        Items::TITLE_IMAGE_PATH[$topmenu]
                ];break;
        }
    }
}

<?php

namespace app\models\globals;

use app\models\ItemsTransport;
use app\models\PhotoTransport;
use app\models\PropertiesGroup;
use app\models\TransportProp;
use app\models\Users;
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
    private $user;

    const TRANSPORTPROPSTABLE = [ 
            'transport_prop'
        ];

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
        $this->user = Users::id();
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

    public function getTablePropertiesSearch($model)
    {
        return self::TRANSPORTPROPSTABLE[--$model];
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
        $itemsLive = $active->getItemsLive($this->user);
        $arr = [];

        foreach ($itemsLive as $item) {
            $arr[] = $this->getModel($item->topmenu_id,$item->items_id);
        }
        return $arr;
    }

    public function getMistakeItems()
    {
        $active = new ModerationMistake();
        $itemsModeration = $active->getItemsModeration($this->user);
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
        $query = [
            'topmenu_id'=>$topmenu,
            'item_id' =>$items
        ];

        switch ($topmenu)
        {
            case self::TRANSPORT : return [
                        (new PhotoTransport())->getPhoto($query),
                        Items::TITLE_IMAGE_PATH[$topmenu]
                ];break;
        }
    }

    public function getLikeItems($top,$items)
    {
        $modelItems = new Items();

        $data = $this->getItemsTable($top,$items);
        $catalog = $this->table->catalog_id;

        $this->getTableProperties($top);
        $item = $this->query
            ->select('id')
            ->where([
                'catalog_id' => $this->table->catalog_id
            ])
            ->andWhere(['not in','id',[$items]])
            ->asArray()
            ->all();

        $items_arr = [];
        foreach ($item as $itemss) {
            $items_arr[] = $itemss['id'];
        }

        $ItemsVip = $modelItems->showItems(Items::STATUS_VIP,['topmenu' => $top, 'items' => $items_arr]);
        $modelVip = [];
        foreach ($ItemsVip as $item) {
            $modelVip[$item->id] = $modelItems->getPath($item->topmenu_id).'/'.$item->topmenu->getPhotoTransports()->where(['item_id'=>$item->items_id])->one()->title;
        }
        return [
            'itemsVip' => $ItemsVip,
            'modelVip' => $modelVip
        ];
    }

    private function builderQuery($params = [])
    {
        switch ($params['topmenu'])
        {
            case self::TRANSPORT : return with(['topmenu.itemsTransports','topmenu.itemsTransports.transportProps']);break;
        }

        $query = with();
    }
}

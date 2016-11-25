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

    /**
     * таблиця з свойствами товарыв групи ТРАНСПОРТ .Використовуэться як запрос до бази
     */
    const TRANSPORTPROPSTABLE = [ 
            '1' => 'transport_prop'
        ];
    /**
     * связь з таблицею transportProps . Використовуэться в запросі як связь
     */
    const TRANSPORTPROPS = 'transportProps';
    /**
     * return views specific of items . Підгружає конкретну необхіжну вюху
     */
    const VIEWS = [
      '1' => 'transport/tires'
    ];
    /**
     * return specific scenario . Сценарій для обробки запиту по збереженню товару АВТОШИНА
     */
    const SCENARIES = [
      '1' => 'transport_tires'
    ];
    /**
     * link of topmenu. Порядковий номер головного меню.
     */
    const TRANSPORT = 1;
    /**
     * link of catalog. Порядковий номер каталога
     */
    const TIRES = 1;

    public function __construct(array $config = [])
    {
        $this->user = Users::id();//беру ід користувача. Якщо зареєстрований верне ід якщо ні верне null.
        $this->catalog = (isset($config['catalog'])) ? $config['catalog'] : null; // устанавдюю приватну змінну Каталог. Якщо створюєш товар то прийме значення ід каталогу в якому створюєш товар
                                                                // інакше верне null

        if($this->catalog)//якщо встановлений кталог тобто якщо свтрорюєш товар
        {
            return $this->setParams();//устанавлюю праметри по замовчуванню згідно вибраного каталогу
        }
    }

    private function setParams()
    {
        switch($this->catalog)
        {
            case self::TIRES : //якщо каталог товарів Автошини
                                    $this->topmenu = self::TRANSPORT;//вказівник що цей каталог знаходиться в блокомі ТРАНСПОРТ
                                    $this->table = new ItemsTransport();//вказівник на таблицю куди запишу товар
                                    $this->table_properties = self::TRANSPORTPROPSTABLE[($this->catalog)];//вказую таблицю в яку писатиму значення всых властивостей новостворенного товару
                                    $this->properties = (new PropertiesGroup($this->catalog))->getAllProp();//вибираю перелык всых властивостей товару згыдно вибранного каталогу
                                    $this->view = self::VIEWS[$this->catalog];//вказую яку вюху показувати
                                    $this->scenaries = self::SCENARIES[$this->catalog];//створюю сценарій для роботи з введенними данними
        }
    }

    /**
     * @return array вернаю масив параметрів по замовчуванню згідно конкретного каталогу
     */
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
     * @param $model айдішнік головного каталогу
     * @return mixed
     * вертаю таблицю в якій шукати свойства тораву
     */
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
                                    $this->query = ItemsTransport::find();//відповідно до $model вказую з якої таблиці шукати товар
                                    return self::TRANSPORTPROPS;break;//вказую связь
        }
    }

    /**
     * @param $model
     * @param $id
     * @param $user
     * @return array|null|\yii\db\ActiveRecord
     * виборка конкретного товару
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
     * виборка конкретного товару
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
     * складна виборка товару з усіма свойствами..
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

    /**
     * @param $user
     * @return array
     * товари користувача на модерації
     */
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

    /**
     * @return array
     * товари користувача які пройшли модерацію
     */
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

    /**
     * @return array
     * товари користувача які не пройшли модерацію та будуть видалені
     */
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

    /**
     * @param $topmenu
     * @param $items
     * @return array
     * титульне фото конкретного товару
     */
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

    /**
     * @param $top
     * @param $items
     * @return array
     * схожі товари
     */
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
}

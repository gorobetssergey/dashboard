<?php

namespace app\models;

use app\models\globals\UploadForm;
use app\models\Topmenu;
use app\models\StatusItems;
use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topmenu_id
 * @property integer $items_id
 * @property string $name
 * @property integer $status
 * @property integer $queue
 *
 * @property Topmenu $topmenu
 * @property StatusItems $status0
 * @property Users $user
 */
class Items extends \yii\db\ActiveRecord
{
    const STATUS_DEFAULT = 0;

    const STATUS_VIP = 1;
    const STATUS_TOP = 2;
    const STATUS_STANDART = 3;

    public $name_tires;
    public $price_tires;
    public $brand_name_tires;
    public $season_tires;
    public $width_tires;
    public $side_view_tires;
    public $diameter_tires;
    public $car_type_tires;
    public $thorns_tires;
    public $can_thorns_tires;
    public $descriptions_tires;

    public $titleImage;

    const TITLE_IMAGE_PATH = [
      '1' => 'transport'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topmenu_id', 'items_id', 'name', 'status', 'queue'], 'required'],
            [['user_id', 'topmenu_id', 'items_id', 'name'], 'safe'],
            [['user_id', 'topmenu_id', 'items_id', 'status', 'queue'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['topmenu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['topmenu_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => StatusItems::className(), 'targetAttribute' => ['status' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            /**
             * rulles for transport_tires
             */
            [['titleImage', 'name_tires','price_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires','descriptions_tires'],'required','on' => 'transport_tires'],
            [['price_tires'], 'integer','max'=>10000000,'min'=>1, 'on' => 'transport_tires'],
            [['name_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires'],'string','max'=>50,'on' => 'transport_tires'],
            [['descriptions_tires'],'string','max'=>2000,'on' => 'transport_tires'],
            [['titleImage'], 'image', 'skipOnEmpty' => false, 'enableClientValidation'=>true,
                'extensions' => 'jpg', 'mimeTypes'=>['image/jpeg'], 'maxSize'=>512000, 'maxWidth'=>800, 'maxHeight'=>600, 'on' => 'transport_tires']
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'topmenu_id' => Yii::t('app', 'Topmenu ID'),
            'items_id' => Yii::t('app', 'Items ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'queue' => Yii::t('app', 'Queue'),
            'titleImage' => Yii::t('cabinet', 'titleImage'),
            /**
             * atributes for transport_tires
             */
            'price_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['price_tires'],
            'title_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['title_tires'],
            'brand_name_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['brand_name_tires'],
            'season_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['season_tires'],
            'width_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['width_tires'],
            'side_view_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['side_view_tires'],
            'diameter_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['diameter_tires'],
            'car_type_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['car_type_tires'],
            'thorns_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['thorns_tires'],
            'can_thorns_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['can_thorns_tires'],
            'descriptions_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['descriptions_tires'],
            'name_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['name_tires']
        ];
    }

    public function scenarios()
    {
        return [
            'transport_tires' => ['name_tires','price_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires','descriptions_tires', 'titleImage'],
            'after_moderation' => ['user_id', 'topmenu_id', 'items_id', 'name', 'status', 'queue'],
            'get_self_active_items' => ['user_id'],//перевырити щоб преданий юзер був тим хто даэ запрос
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopmenu()
    {
        return $this->hasOne(Topmenu::className(), ['id' => 'topmenu_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(StatusItems::className(), ['id' => 'status']);
    }

    public function getItems($user)
    {
        return self::find()->where(['user_id' => $user])->count();
    }

    private function setPath($topmenu)
    {
        return __DIR__.'/../images/items/'.self::TITLE_IMAGE_PATH[$topmenu] . '/';
    }

    public function getPath($topmenu)
    {
        return self::TITLE_IMAGE_PATH[$topmenu] . '/';
    }
    
    public function setName($topmenu, $time)
    {
        return self::TITLE_IMAGE_PATH[$topmenu].'_'.Users::id().'_'.$time.'.' . $this->titleImage->extension;
    }
    
    public function uploadTitle($topmenu,$image, $time)
    {        
        if ($this->validate()) {
            return (new UploadForm())->upload($image, $this->setPath($topmenu) . $this->setName($topmenu,$time));
        } else {
            return false;
        }
    }

    public function getItemsLive($user)
    {
        return self::find()
            ->where([
                'user_id' => $user
            ])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    public function getLastQueue()
    {
        $queue = self::find()->orderBy(['queue'=>SORT_DESC])->one()['queue'];
        if($queue)
        {
            return $queue++;
        }
        return self::STATUS_DEFAULT;
    }
    /* Index */
    public function showItems($status)
    {
        $items = self::find()
            ->with(['topmenu','topmenu.itemsTransports','topmenu.itemsTransports.transportProps'])
            ->where([
                'status' => $status
            ])
            ->orderBy(['queue'=>SORT_ASC])
            ->limit(25)
            ->all();
        return $items;
    }

    public function findItems($id)
    {
        $items = self::find()
            ->with(['topmenu','topmenu.itemsTransports','topmenu.itemsTransports.transportProps'])
            ->where([
                'id' => $id
            ])
            ->one();
        return ($items->id>0) ? $items : null;
    }
    /* Index End*/


}

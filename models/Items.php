<?php

namespace app\models;

use app\models\Topmenu;
use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topmenu_id
 * @property integer $items_id
 * @property string $name
 *
 * @property Topmenu $topmenu
 * @property Users $user
 */
class Items extends \yii\db\ActiveRecord
{
    const STATUS_DEFAULT = 0;

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
            [['user_id', 'topmenu_id', 'items_id', 'name'], 'required'],
            [['user_id', 'topmenu_id', 'items_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['topmenu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['topmenu_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            /**
             * rulles for transport_tires
             */
            [['name_tires','price_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires','descriptions_tires'],'required','on' => 'transport_tires'],
            [['price_tires'], 'integer','max'=>10000000,'min'=>1, 'on' => 'transport_tires'],
            [['name_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires'],'string','max'=>50,'on' => 'transport_tires'],
            [['descriptions_tires'],'string','max'=>2000,'on' => 'transport_tires']
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
            /**
             * atributes for transport_tires
             */
            'price_tires' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['price_tires'],
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
            'transport_tires' => ['name_tires','price_tires','brand_name_tires','season_tires','width_tires','side_view_tires','diameter_tires','car_type_tires','thorns_tires','can_thorns_tires','descriptions_tires'],
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
}

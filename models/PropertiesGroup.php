<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "properties_group".
 *
 * @property integer $id
 * @property integer $group
 * @property integer $prop_id
 *
 * @property ItemsTransport[] $itemsTransports
 * @property Properties $prop
 */
class PropertiesGroup extends \yii\db\ActiveRecord
{
    private $group;

    const PROPERTIES = [
        '1' => [
            'price_tires',/*price*/
            'brand_name_tires',/*brand*/
            'season_tires',/*season*/
            'width_tires',/*width (205)*/
            'side_view_tires',/*side_view (65)*/
            'diameter_tires',/*diameter (16)*/
            'car_type_tires',/*car_type (cards trucks)*/
            'thorns_tires',/*thorns*/
            'can_thorns_tires',/*can_thorns*/
            'delivery_tires',
            'old_tires',
            'description_tires',
            'name_tires'
        ]
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties_group';
    }

    public function __construct($config = null)
    {
        $this->group = $config;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'prop_id'], 'integer'],
            [['prop_id'], 'required'],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::className(), 'targetAttribute' => ['prop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group' => Yii::t('app', 'Group'),
            'prop_id' => Yii::t('app', 'Prop ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsTransports()
    {
        return $this->hasMany(ItemsTransport::className(), ['prop_group' => 'group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(Properties::className(), ['id' => 'prop_id']);
    }

    public function getAllProp()
    {
        return self::PROPERTIES[$this->group];
    }
}

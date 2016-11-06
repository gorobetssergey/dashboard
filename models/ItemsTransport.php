<?php

namespace app\models;

use Yii;
use app\models\Properties;

/**
 * This is the model class for table "items_transport".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $catalog_id
 * @property integer $topmenu_id
 * @property integer $prop_group
 * @property string $created_at
 * @property string $updated_at
 * @property string $description
 * @property integer $status
 *
 * @property Catalog $catalog
 * @property PropertiesGroup $propGroup
 * @property Topmenu $topmenu
 * @property Users $user
 * @property TransportProp[] $transportProps
 */
class ItemsTransport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items_transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'catalog_id', 'topmenu_id', 'prop_group', 'created_at', 'updated_at', 'description'], 'required'],
            [['user_id', 'catalog_id', 'topmenu_id', 'prop_group', 'status'], 'integer'],
            [['user_id', 'catalog_id', 'topmenu_id', 'prop_group', 'created_at', 'updated_at', 'description'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
            [['prop_group'], 'exist', 'skipOnError' => true, 'targetClass' => PropertiesGroup::className(), 'targetAttribute' => ['prop_group' => 'groups']],
            [['topmenu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['topmenu_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'topmenu_id' => Yii::t('app', 'Topmenu ID'),
            'prop_group' => Yii::t('app', 'Prop Group'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropGroup()
    {
        return $this->hasOne(PropertiesGroup::className(), ['group' => 'prop_group']);
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
    public function getTransportProps()
    {
        return $this->hasMany(TransportProp::className(), ['items_id' => 'id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try{
            $this->user_id = $attributeNames['user_id'];
            $this->catalog_id = $attributeNames['catalog_id'];
            $this->topmenu_id = $attributeNames['topmenu_id'];
            $this->prop_group = $attributeNames['prop_group'];
            $this->created_at = $attributeNames['created_at'];
            $this->updated_at = $attributeNames['updated_at'];
            $this->status = $attributeNames['status'];
            $this->description = $_POST["Items"]["descriptions_tires"];
            $res1 = parent::save();

            $attributeNames["dataitems"]['model']->items_id = $this->id;
            $attributeNames["dataitems"]['model']->topmenu_id = $attributeNames["dataitems"]['topmenu_id'];
            $attributeNames["dataitems"]['model']->name = $attributeNames["dataitems"]['name'];
            $res2 = $attributeNames["dataitems"]['model']->save();

            $properties = [
                [$this->id, 1 , $_POST['Items']['price_tires']],
                [$this->id, 2 , Properties::BREND_TIRES[$_POST['Items']['brand_name_tires']]],
                [$this->id, 3 , Properties::SEASON_TIRES[$_POST['Items']['season_tires']]],
                [$this->id, 4 , Properties::WIDTH_TIRES[$_POST['Items']['width_tires']]],
                [$this->id, 5 , Properties::SIDE_VIEW_TIRES[$_POST['Items']['side_view_tires']]],
                [$this->id, 6 , Properties::DIAMETER_TIRES[$_POST['Items']['diameter_tires']]],
                [$this->id, 7 , Properties::CAR_TYPE_TIRES[$_POST['Items']['car_type_tires']]],
                [$this->id, 8 , Properties::THORNS_TIRES[$_POST['Items']['thorns_tires']]],
                [$this->id, 9 , Properties::CAN_THORNS_TIRES[$_POST['Items']['can_thorns_tires']]],
                [$this->id, 10 , $_POST['Items']['descriptions_tires']],
                [$this->id, 11 , $_POST['Items']['name_tires']],
            ];
            
            $res3 = Yii::$app->db->createCommand()->batchInsert($attributeNames['table_properties'], ['items_id','prop_id','value'], $properties)->execute();

            $moderators = new Moderation();
            $moderators->attributes = ['topmenu_id' => $attributeNames['topmenu_id'],'items_id' => $this->id];
            $res4 = $moderators->save();
            if($res1 && $res2 && $res3 && $res4)
            {
                $transaction->commit();
                return true;
            }
        }catch (Exception $ex) {
            $transaction->rollBack();
            return false;
        }
    }
}
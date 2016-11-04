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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties_group';
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
}

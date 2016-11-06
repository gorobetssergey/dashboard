<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transport_prop".
 *
 * @property integer $id
 * @property integer $items_id
 * @property integer $prop_id
 * @property string $value
 *
 * @property ItemsTransport $items
 * @property Properties $prop
 */
class TransportProp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_prop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['items_id', 'prop_id', 'value'], 'required'],
            [['items_id', 'prop_id'], 'integer'],
            [['value'], 'string', 'max' => 50],
            [['items_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemsTransport::className(), 'targetAttribute' => ['items_id' => 'id']],
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
            'items_id' => Yii::t('app', 'Items ID'),
            'prop_id' => Yii::t('app', 'Prop ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasOne(ItemsTransport::className(), ['id' => 'items_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(Properties::className(), ['id' => 'prop_id']);
    }
}

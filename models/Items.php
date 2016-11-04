<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $topmenu_id
 * @property integer $items_id
 * @property string $name
 *
 * @property Topmenu $topmenu
 */
class Items extends \yii\db\ActiveRecord
{
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
            [['topmenu_id', 'items_id', 'name'], 'required'],
            [['topmenu_id', 'items_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['topmenu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['topmenu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'topmenu_id' => Yii::t('app', 'Topmenu ID'),
            'items_id' => Yii::t('app', 'Items ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopmenu()
    {
        return $this->hasOne(Topmenu::className(), ['id' => 'topmenu_id']);
    }
}

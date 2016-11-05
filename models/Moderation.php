<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moderation".
 *
 * @property integer $id
 * @property integer $topmenu_id
 * @property integer $items_id
 *
 * @property Topmenu $topmenu
 */
class Moderation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'moderation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topmenu_id', 'items_id'], 'required'],
            [['topmenu_id', 'items_id'], 'safe'],
            [['topmenu_id', 'items_id'], 'integer'],
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

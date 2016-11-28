<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "top_sub".
 *
 * @property integer $id
 * @property integer $id_top
 * @property integer $id_sub
 *
 * @property Submenu $idSub
 * @property Topmenu $idTop
 */
class TopSub extends Topmenu
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_top', 'id_sub'], 'required'],
            [['id_top', 'id_sub'], 'integer'],
            [['id_sub'], 'exist', 'skipOnError' => true, 'targetClass' => Submenu::className(), 'targetAttribute' => ['id_sub' => 'id']],
            [['id_top'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['id_top' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_top' => Yii::t('app', 'Id Top'),
            'id_sub' => Yii::t('app', 'Id Sub'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSub()
    {
        return $this->hasOne(Submenu::className(), ['id' => 'id_sub']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTop()
    {
        return $this->hasOne(Topmenu::className(), ['id' => 'id_top']);
    }
}

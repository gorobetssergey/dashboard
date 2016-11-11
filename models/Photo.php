<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topmenu_id
 * @property integer $item_id
 * @property string $title
 * @property string $photo_1
 * @property string $photo_2
 * @property string $photo_3
 * @property string $photo_4
 * @property string $photo_5
 * @property string $photo_6
 * @property string $photo_7
 * @property string $photo_8
 * @property string $photo_9
 * @property string $photo_10
 *
 * @property ItemsTransport[] $itemsTransports
 * @property Topmenu $topmenu
 * @property Users $user
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topmenu_id', 'item_id'], 'required'],
            [['user_id', 'topmenu_id', 'item_id'], 'integer'],
            [['title', 'photo_1', 'photo_2', 'photo_3', 'photo_4', 'photo_5', 'photo_6', 'photo_7', 'photo_8', 'photo_9', 'photo_10'], 'string', 'max' => 100],
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
            'topmenu_id' => Yii::t('app', 'Topmenu ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'title' => Yii::t('app', 'Title'),
            'photo_1' => Yii::t('app', 'Photo 1'),
            'photo_2' => Yii::t('app', 'Photo 2'),
            'photo_3' => Yii::t('app', 'Photo 3'),
            'photo_4' => Yii::t('app', 'Photo 4'),
            'photo_5' => Yii::t('app', 'Photo 5'),
            'photo_6' => Yii::t('app', 'Photo 6'),
            'photo_7' => Yii::t('app', 'Photo 7'),
            'photo_8' => Yii::t('app', 'Photo 8'),
            'photo_9' => Yii::t('app', 'Photo 9'),
            'photo_10' => Yii::t('app', 'Photo 10'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsTransports()
    {
        return $this->hasMany(ItemsTransport::className(), ['photo' => 'id']);
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

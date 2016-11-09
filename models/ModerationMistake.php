<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moderation_mistake".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topmenu_id
 * @property integer $items_id
 * @property string $descriptions
 *
 * @property Topmenu $topmenu
 * @property Users $user
 */
class ModerationMistake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'moderation_mistake';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'items_id', 'descriptions'], 'required'],
            [['user_id', 'topmenu_id', 'items_id'], 'integer'],
            [['user_id', 'topmenu_id', 'items_id', 'descriptions'], 'safe'],
            [['descriptions'], 'string', 'max' => 255],
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
            'items_id' => Yii::t('app', 'Items ID'),
            'descriptions' => Yii::t('app', 'Descriptions'),
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

    public function getItems($user)
    {
        return self::find()
            ->where([
                'user_id' => $user
            ])
            ->count();
    }

    public function getItemsModeration($user)
    {
        return self::find()
            ->where([
                'user_id' => $user
            ])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
}

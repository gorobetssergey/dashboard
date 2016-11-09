<?php

namespace app\models;

use app\models\globals\GlobalTables;
use Yii;

/**
 * This is the model class for table "topmenu".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Items[] $items
 * @property ItemsTransport[] $itemsTransports
 * @property TopSub[] $topSubs
 */
class Topmenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topmenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::className(), ['topmenu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsTransports()
    {
        return $this->hasMany(ItemsTransport::className(), ['topmenu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopSubs()
    {
        return $this->hasMany(TopSub::className(), ['id_top' => 'id']);
    }

    public function getItemsTable($topmenu)
    {
        switch($topmenu->topmenu_id)
        {
            case GlobalTables::TRANSPORT :
                                            return $this->itemsTransports;break;
        }
    }
}

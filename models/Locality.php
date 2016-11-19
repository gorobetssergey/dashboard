<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\Json;

/**
 * This is the model class for table "locality".
 *
 * @property integer $id
 * @property string $title
 * @property string $abbreviations
 * @property integer $parent_id
 * @property integer $number
 * @property string $type
 */
class Locality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'number'], 'integer'],
            [['title', 'type'], 'string', 'max' => 255],
            [['abbreviations'], 'string', 'max' => 3],
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
            'abbreviations' => Yii::t('app', 'Abbreviations'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'number' => Yii::t('app', 'Number'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
    public static function returnetown($s = null)
    {
        $query = (new Query())
            ->select('title')
            ->from('locality')
            ->where('title LIKE "%' . $s .'%"')
            ->orderBy('title');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['title']];
        }
        return Json::encode($out);
    }

    public function getCity($city)
    {
        $model = self::findOne(['title' => $city]);
        if ($model !== null) {
            return true;
        } else {
            return false;
        }
    }
}

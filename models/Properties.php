<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property integer $id
 * @property string $name
 *
 * @property PropertiesGroup[] $propertiesGroups
 * @property TransportProp[] $transportProps
 */
class Properties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertiesGroups()
    {
        return $this->hasMany(PropertiesGroup::className(), ['prop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportProps()
    {
        return $this->hasMany(TransportProp::className(), ['prop_id' => 'id']);
    }
}

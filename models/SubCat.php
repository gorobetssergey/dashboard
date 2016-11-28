<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_cat".
 *
 * @property integer $id
 * @property integer $id_sub
 * @property integer $id_cat
 *
 * @property Catalog $idCat
 * @property Submenu $idSub
 */
class SubCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sub', 'id_cat'], 'integer'],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_sub'], 'exist', 'skipOnError' => true, 'targetClass' => Submenu::className(), 'targetAttribute' => ['id_sub' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_sub' => Yii::t('app', 'Id Sub'),
            'id_cat' => Yii::t('app', 'Id Cat'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSub()
    {
        return $this->hasOne(Submenu::className(), ['id' => 'id_sub']);
    }

    public function getListSubMenu($id_sub)
    {
        $list = self::find()
            ->with('idCat')
            ->where(['id_sub' => $id_sub])
            ->all();
        return $list;
    }
    public function getList()
    {
        $list = self::find()
            ->select(['id_sub'])
            ->distinct('id_sub')
            ->all();
        return $list;
    }
}

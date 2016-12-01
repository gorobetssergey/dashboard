<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "submenu".
 *
 * @property integer $id
 * @property string $title
 *
 * @property SubCat[] $subCats
 * @property TopSub[] $topSubs
 */
class Submenu extends \yii\db\ActiveRecord
{
    private $submenu;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'submenu';
    }

    public function __construct($config = [])
    {
//        $this->submenu = 18;
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
    public function getSubCats()
    {
        return $this->hasMany(SubCat::className(), ['id_sub' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopSubs()
    {
        return $this->hasMany(TopSub::className(), ['id_sub' => 'id']);
    }

    public function getSubmenu()
    {
        return $this->submenu;
    }
}

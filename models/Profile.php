<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ownership
 * @property string $tel_first
 * @property string $tel_sec
 * @property string $tel_next
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $city
 * @property integer $level
 *
 * @property Level $level0
 * @property Ownership $ownership0
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ownership', 'tel_first'], 'required'],
            [['user_id', 'ownership', 'level'], 'integer'],
            [['tel_first', 'tel_sec', 'tel_next'], 'required','on'=>'edit'],
            [['tel_first', 'tel_sec', 'tel_next'],'string','max' => 15],
            [['name', 'surname', 'patronymic', 'city'], 'string', 'max' => 50],
            [['level'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level' => 'id']],
            [['ownership'], 'exist', 'skipOnError' => true, 'targetClass' => Ownership::className(), 'targetAttribute' => ['ownership' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ownership' => 'Ownership',
            'tel_first' => 'телефон 1',
            'tel_sec' => 'телефон 2',
            'tel_next' => 'телефон 3',
            'name' => 'имя',
            'surname' => 'фамилия',
            'patronymic' => 'отчество',
            'city' => 'город',
            'level' => 'Level',
        ];
    }
    public function scenarios()
    {
        return [
            'default' => 'edit',
            'edit' => ['tel_first', 'tel_sec', 'tel_next', 'name', 'surname', 'patronymic', 'city'],

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel0()
    {
        return $this->hasOne(Level::className(), ['id' => 'level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnership0()
    {
        return $this->hasOne(Ownership::className(), ['id' => 'ownership']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getForm($id)
    {
        $profile = self::find()
            ->where(['profile.user_id' => $id])
            ->one();
        return $profile;
    }

    public function updateProfile($model)
    {
        $profile = self::findOne(['user_id' => $model['user_id']]);
        $profile->setScenario('edit');
        $profile->tel_first = $model['tel_first'];
        $profile->tel_sec = $model['tel_sec'];
        $profile->tel_next = $model['tel_next'];
        $profile->name = $model['name'];
        $profile->surname = $model['surname'];
        $profile->patronymic = $model['patronymic'];
        $profile->city = $model['city'];
        return $profile->update();

    }
}

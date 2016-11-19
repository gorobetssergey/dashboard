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
    const INCOGNITO = 1;
    const TEL_DEFAULT = '+380000000000';
    const LEVEL_BONUS = 1;

    const OWNERSHIP = [
        '1' => 'incognito',
        '3' => 'entity',
        '4' => 'individual',
    ];
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
            [['tel_first', 'tel_sec', 'tel_next'],'string','max' => 20],
            [['name', 'surname', 'patronymic', 'city'], 'string', 'max' => 50],
            [['level'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level' => 'id']],
            [['ownership'], 'exist', 'skipOnError' => true, 'targetClass' => Ownership::className(), 'targetAttribute' => ['ownership' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id'], 'required','on'=>'save_p'],
            [['user_id', 'ownership', 'tel_first', 'tel_sec', 'tel_next', 'name', 'surname', 'patronymic', 'city', 'level'], 'safe', 'on' => 'save_p'],
            /**
             * scenario edit
             */
            [['tel_first','name', 'city'], 'required','on'=>'edit'],
            ['ownership','checkOwnership','on'=>'edit'],
            ['city','checkCity','on'=>'edit']

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
            'ownership' => 'Форма собственности',
            'tel_first' => 'телефон 1',
            'tel_sec' => 'телефон 2',
            'tel_next' => 'телефон 3',
            'name' => 'имя',
            'surname' => 'фамилия',
            'patronymic' => 'отчество',
            'city' => 'Город',
            'level' => 'Level',
        ];
    }
    public function scenarios()
    {
        return [
            'default' => 'edit',
            'edit' => ['tel_first', 'tel_sec', 'tel_next', 'name', 'surname', 'patronymic', 'city','ownership','city'],
            'save_p' => ['user_id', 'ownership', 'tel_first', 'tel_sec', 'tel_next', 'name', 'surname', 'patronymic', 'city', 'level'],

        ];
    }

    public function checkCity($atribute)
    {
        if(!(new Locality())->getCity($this->$atribute))
        {
            $this->addError($atribute,'Указанного вами населенного пункта неу в базе. Укажите ближайший к вам населенный пункт');
            return false;
        }
        return true;
    }

    public function checkOwnership($atribute)
    {
        if($this->$atribute == self::INCOGNITO)
        {
            $this->addError($atribute,'Выберите форму собственности');
            return false;
        }
        return true;
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

    public function getOwnership()
    {
        $arr = [];
        foreach (self::OWNERSHIP as $k=>$v) {
            $arr[$k] = Yii::t('cabinet','ownership')[$v];
        }
        return $arr;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function defaultSave($user)
    {
        $this->user_id = $user;
        $this->ownership = self::INCOGNITO;
        $this->tel_first =  self::TEL_DEFAULT;
        $this->tel_sec = '';
        $this->tel_next = '';
        $this->name = 'Name';
        $this->surname = '';
        $this->patronymic = '';
        $this->city = 'City';
        $this->level = self::LEVEL_BONUS;

        return $this->save();
    }
    public static function getName($id)
    {
        $user = self::findOne(['user_id' => $id]);
        return $user->surname.' '.$user->name;
    }
}

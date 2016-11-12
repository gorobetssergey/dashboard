<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property integer $active
 * @property string $password
 * @property string $repassword
 * @property string $token
 * @property integer $role
 * @property string $created
 * @property integer $auth
 *
 * @property Items[] $items
 * @property ItemsTransport[] $itemsTransports
 * @property Moderation[] $moderations
 * @property ModerationMistake[] $moderationMistakes
 * @property PhotoTransport[] $photoTransports
 * @property Profile[] $profiles
 * @property Serviseitems[] $serviseitems
 * @property Role $role0
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'repassword', 'token', 'created'], 'required'],
            [['active', 'role', 'auth'], 'integer'],
            [['created'], 'safe'],
            [['email'], 'string', 'max' => 30],
            [['password', 'repassword', 'token'], 'string', 'max' => 255],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'id']],
            [['email', 'password'], 'required', 'on' => 'user_reg'],
            [['email', 'password'], 'required', 'on' => 'user_login'],
            [['email'], 'email', 'on' => 'user_reg'],
            [['email'], 'email', 'on' => 'user_login'],
            [['password'], 'validatePassword', 'on' => 'user_login'],
            [['email'], 'unique', 'targetClass'=>'App\models\Users', 'on' => 'user_reg'],
            [['password'], 'string', 'min'=> 8, 'max'=>100, 'on' => 'user_reg'],
        ];
    }
    public function scenarios()
    {
        return [
            'user_reg' => ['email', 'password'],
            'user_login' => ['email', 'password'],
        ];
    }

    /* interfase*/
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {

    }
    public function validateAuthKey($authKey)
    {

    }

    /* interfase End*/

    public function validatePassword($attribyte, $params)
    {
        $user = User::findOne(['email' => $this->email]);
        if(!$user || $user->password != sha1($this->password)){
            $this->addError($attribyte, 'p || u');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'active' => Yii::t('app', 'Active'),
            'password' => Yii::t('app', 'Password'),
            'repassword' => Yii::t('app', 'Repassword'),
            'token' => Yii::t('app', 'Token'),
            'role' => Yii::t('app', 'Role'),
            'created' => Yii::t('app', 'Created'),
            'auth' => Yii::t('app', 'Auth'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsTransports()
    {
        return $this->hasMany(ItemsTransport::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModerations()
    {
        return $this->hasMany(Moderation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModerationMistakes()
    {
        return $this->hasMany(ModerationMistake::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoTransports()
    {
        return $this->hasMany(PhotoTransport::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiseitems()
    {
        return $this->hasMany(Serviseitems::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }

    public function registrationUser($model)
    {
        $user= new Users();
        $user->setScenario('user_reg');
        $user->email = $model['email'];
        $user->active = 1;
        $user->password = $model['password'];
        $user->repassword = 0;
        $user->token = 0;
        $user->role = 1;
        $user->created = date('Y-m-d H-i-s');
        $user->auth = 1;
        return $user->save();
    }

    public function existEmail($email)
    {
        $exists = self::find()
            ->where([
                'email' => $email
            ])
            ->exists();
        return $exists;
    }

    public function validateUser($model)
    {
        $user = self::find()
            ->where([
                'email' => $model['email'],
                'password' => $model['password']
            ])
            ->one();
        return $user;

    }
}

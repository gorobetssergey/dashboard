<?php

namespace app\models;

use Yii;
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
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 1;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_MODERATOR = 3;

    public $repet_password;
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
            /**
             * scenarios registration
             */
            [['email', 'password', 'repet_password'], 'required', 'on'=>'registration'],
            [['email'], 'string','max' => 30, 'on'=>'registration'],
            [['password', 'repet_password'], 'string', 'min' => 6,'max' => 30, 'on'=>'registration'],
            ['email', 'unique'],
            ['repet_password', 'compare', 'compareAttribute'=>'password', 'on' => 'registration' ],
        ];
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
            'repet_password' => 'Повторить пароль'
        ];
    }

    public function scenarios()
    {
        return [
            'registration' => ['email','password','repet_password'],
            'default' => parent::scenarios()
        ];
    }

    public static function findByUserEmail($useremail)
    {
        return self::findOne([
            'email' => $useremail
        ]);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->token = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password);
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

    /**
     * IdentityInterface
     */

    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'active' => self::STATUS_ACTIVE
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->token === $authKey;
    }

    private function getRole()
    {
        $this->role = self::ROLE_USER;
    }

    public static function id()
    {
        return Yii::$app->user->identity->getId();
    }

    public function reg()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $res1 = false;
            $res2 = false;

            $user = new Users();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->getRole();
            $user->repassword = $user->password;
            $user->created = date('Y-m-d H:i:s', strtotime('now'));
            $user->active = self::STATUS_ACTIVE;
            $user->auth = 0;

            $res1 = $user->save();

            $model_profile = new Profile(['scenario' => 'save_p']);
            $res2 = $model_profile->defaultSave($user->id);

            if($res1 && $res2){
                $transaction->commit();
                return $user;
            }else{
                $transaction->rollBack();
                return null;
            }
        }
        catch (Exception $e){
            $transaction->rollBack();
        }
        return null;
    }
}

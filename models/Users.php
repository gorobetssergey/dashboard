<?php

namespace app\models;

use Yii;

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
 * @property ItemsTransport[] $itemsTransports
 * @property Profile[] $profiles
 * @property Role $role0
 */
class Users extends \yii\db\ActiveRecord
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
        ];
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
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }
}

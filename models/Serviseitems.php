<?php

namespace app\models;

use app\models\globals\GlobalTables;
use Yii;

/**
 * This is the model class for table "serviseitems".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $transport
 * @property integer $real_estate
 * @property integer $child_world
 * @property integer $job
 * @property integer $animals
 * @property integer $house_garden
 * @property integer $electronics
 * @property integer $business_and_services
 * @property integer $fashion_style
 * @property integer $sport
 * @property integer $helping
 * @property integer $giveAwey
 * @property integer $exchange
 *
 * @property Users $user
 */
class Serviseitems extends \yii\db\ActiveRecord
{
    private $user_id;

    private $transport = 0;
    private $real_estate = 0;
    private $child_world = 0;
    private $job = 0;
    private $animals = 0;
    private $house_garden = 0;
    private $electronics = 0;
    private $business_and_services = 0;
    private $fashion_style = 0;
    private $sport = 0;
    private $helping = 0;
    private $giveAwey = 0;
    private $exchange = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'serviseitems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'transport', 'real_estate', 'child_world', 'job', 'animals', 'house_garden', 'electronics', 'business_and_services', 'fashion_style', 'sport', 'helping', 'giveAwey', 'exchange'], 'integer'],
            [['user_id', 'transport', 'real_estate', 'child_world', 'job', 'animals', 'house_garden', 'electronics', 'business_and_services', 'fashion_style', 'sport', 'helping', 'giveAwey', 'exchange'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'transport' => Yii::t('app', 'Transport'),
            'real_estate' => Yii::t('app', 'Real Estate'),
            'child_world' => Yii::t('app', 'Child World'),
            'job' => Yii::t('app', 'Job'),
            'animals' => Yii::t('app', 'Animals'),
            'house_garden' => Yii::t('app', 'House Garden'),
            'electronics' => Yii::t('app', 'Electronics'),
            'business_and_services' => Yii::t('app', 'Business And Services'),
            'fashion_style' => Yii::t('app', 'Fashion Style'),
            'sport' => Yii::t('app', 'Sport'),
            'helping' => Yii::t('app', 'Helping'),
            'giveAwey' => Yii::t('app', 'Give Awey'),
            'exchange' => Yii::t('app', 'Exchange'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function defaultData($user, $topmenu)
    {
        $this->user_id = $user;

        switch($topmenu){
            case GlobalTables::TRANSPORT : $this->transport ++ ;break;
        }
        $data = self::findOne(['user_id' => $this->user_id]);
        if($data)
        {
            return $data->updateCounters([
                'transport' => $this->transport,
                'real_estate' => $this->real_estate,
                'child_world' => $this->child_world,
                'job' => $this->job,
                'animals' => $this->animals,
                'house_garden' => $this->house_garden,
                'electronics' => $this->electronics,
                'business_and_services' => $this->business_and_services,
                'fashion_style' => $this->fashion_style,
                'sport' => $this->sport,
                'helping' => $this->helping,
                'giveAwey' => $this->giveAwey,
                'exchange' => $this->exchange,
            ]);
        }else{
            $this->attributes = [
                'user_id' => $this->user_id,
                'transport' => $this->transport,
                'real_estate' => $this->real_estate,
                'child_world' => $this->child_world,
                'job' => $this->job,
                'animals' => $this->animals,
                'house_garden' => $this->house_garden,
                'electronics' => $this->electronics,
                'business_and_services' => $this->business_and_services,
                'fashion_style' => $this->fashion_style,
                'sport' => $this->sport,
                'helping' => $this->helping,
                'giveAwey' => $this->giveAwey,
                'exchange' => $this->exchange,
            ];
            return parent::save();
        }
    }
}

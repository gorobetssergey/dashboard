<?php

namespace app\models;

use app\models\globals\GlobalTables;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "moderation".
 *
 * @property integer $id
 * @property integer $topmenu_id
 * @property integer $items_id
 *
 * @property Topmenu $topmenu
 */
class Moderation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'moderation';
    }

    public function __construct(array $config = [])
    {
        $this->attributes = $config;
        return parent::__construct();
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topmenu_id', 'items_id','user_id'], 'required'],
            [['topmenu_id', 'items_id','user_id'], 'safe'],
            [['topmenu_id', 'items_id','user_id'], 'integer'],
            [['topmenu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topmenu::className(), 'targetAttribute' => ['topmenu_id' => 'id']],
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
            'topmenu_id' => Yii::t('app', 'Topmenu ID'),
            'items_id' => Yii::t('app', 'Items ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopmenu()
    {
        return $this->hasOne(Topmenu::className(), ['id' => 'topmenu_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getItems()
    {
        return self::find()->where(['user_id' => 1])->count();
    }
    public function getAllItems($data)
    {
        return ($data) ? self::find()->count() : self::find()->all();
    }

    public function getProvider()
    {
        $query = self::find()->with(['topmenu']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $dataProvider;
    }

    public function ok($model)
    {
        $modelTable = (new GlobalTables([]))->getItemsTable($model->topmenu->id,$model->items_id);
        if(!$modelTable['itemsTable']->status)
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                $modelTable['itemsTable']->status = 1;
                $res1 = $modelTable['itemsTable']->update();
                $newItems = new Items(['scenario' => 'after_moderation']);

                $newItems->attributes = [
                        'user_id' => $modelTable['itemsTable']->user_id,
                        'topmenu_id' => $modelTable['itemsTable']->topmenu_id,
                        'items_id' => $modelTable['itemsTable']->id,
                        'name' => $modelTable['itemsName'],
                        'status' => Items::STATUS_STANDART,
                        'queue' => $newItems->getLastQueue(),
                ];


                $res2 = $newItems->save();

                $res3 = (new Serviseitems())->defaultData($modelTable['itemsTable']->user_id,$modelTable['itemsTable']->topmenu_id);

                $res4 = $model->delete();

                if($res1 && $res2 && $res3 && $res4)
                {
                    $transaction->commit();
                    return true;
                }
            }catch (Exception $ex) {
                $transaction->rollBack();
                return false;
            }
        }else{
            return false;
        }
    }

    public function no($model, $description)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $mistake = new ModerationMistake();
            $mistake->attributes = [
                'user_id' => $model->user_id,
                'topmenu_id' => $model->topmenu_id,
                'items_id' => $model->id,
                'descriptions' => $description,
            ];

            $res1 = $model->delete();
            $res2 = $mistake->save();

            if($res1 && $res2)
            {
                $transaction->commit();
                return true;
            }else{
                $transaction->rollBack();
                return false;
            }
        }catch (Exception $ex) {
            $transaction->rollBack();
            return false;
        }
    }

    public function getItemsModeration($user)
    {
        return self::find()
            ->where([
                'user_id' => $user
            ])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
}
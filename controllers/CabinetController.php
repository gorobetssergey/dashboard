<?php

namespace app\controllers;

use app\models\globals\GlobalTables;
use app\models\Items;
use Yii;

class CabinetController extends \yii\web\Controller
{
    public $layout = 'cabinet_layout';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionNewItems()
    {
        return $this->render('newItem');
    }

    public function actionAddNewItems($catalog)
    {
        $params = (new GlobalTables(['catalog' => $catalog]))->getParams();
        $items = new Items(['scenario' =>$params['scenario']]);

        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if($items->load($post) && $items->validate())
            {
                $date = date('Y-m-d H:i:s',strtotime('now'));
                $attributeNames = [
                    'user_id' => 1,//Yii::$app->user->identity->id,
                    'catalog_id' => $catalog,
                    'topmenu_id' => $params['topmenu'],
                    'prop_group' => $catalog,
                    'created_at' => $date,
                    'updated_at' => $date,
                    'status' => Items::STATUS_DEFAULT,
                    'description' => 'test',
                    'dataitems' => ['model'=>$items,'topmenu_id'=>$params['topmenu'],'name'=>$post["Items"]["name_tires"]]
                ];
                if($params['table']->save(true,$attributeNames))
                {
                    var_dump('ok');die();
                }
                else{
                    var_dump($params['table']->errors);die();
                }
            }else{
                var_dump(99);die();
            }
        }

        return $this->render($params['view'],[
            'items' => $items
        ]);
    }
}

<?php

namespace app\controllers;

use app\models\globals\GlobalTables;
use app\models\Items;
use app\models\Moderation;
use app\models\ModerationMistake;
use Yii;
use yii\helpers\Url;

class CabinetController extends \yii\web\Controller
{
    public $layout = 'cabinet_layout';
    public function actionIndex()
    {
        return $this->render('index',[
            'items_moderation' => (new Moderation([]))->getItems(),
            'all_items' => (new Items())->getItems(),
            'moderation_er' => (new ModerationMistake())->getItems(1)
        ]);
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
                    'dataitems' => ['topmenu_id'=>$params['topmenu'],'name'=>$post["Items"]["name_tires"]],
                    'table_properties' => $params['table_properties']
                ];
                if($params['table']->save(true,$attributeNames))
                {
                    Yii::$app->getSession()->setFlash('add_new_items_ok', 'Товар успешно направлен на модерацию.');
                    return $this->refresh();
                }
                else{
                    Yii::$app->getSession()->setFlash('add_new_items_err', 'Ошибка данных.');
                    return $this->refresh();
                }
            }else{
                Yii::$app->getSession()->setFlash('add_new_items_err', 'Ошибка данных.');
                return $this->refresh();
            }
        }

        return $this->render($params['view'],[
            'items' => $items
        ]);
    }

    public function actionGetMyActiveItems()
    {
        return $this->render('transport/itemsActive',[
            'items' => (new GlobalTables())->getActivItems()
        ]);
    }

    public function actionGetMyModerationItems()
    {
        return $this->render('transport/itemsModeration',[
            'items' => (new GlobalTables())->getUserItemsInModeration(1)
        ]);
    }

    public function actionGetMyMistakeItems()
    {
        return $this->render('transport/itemsModerationMistake',[
            'items' =>(new GlobalTables())->getMistakeItems()
        ]);
    }

    /**
     * @param $tompenu - id tipmenu in table tomenu
     * @param $id - id items in specific table concrete
     */
    public function actionEditItems($tompenu, $id)
    {
        $propreliation = (new GlobalTables([]))->getTableProperties($tompenu);
        $model = (new GlobalTables([]))->getModel($tompenu, $id, 1);
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $data_model = $model[$propreliation][0];
            if($data_model->load($post) && $data_model->validate())
            {
                if($data_model->update())
                {
                    Yii::$app->getSession()->setFlash('edit_items_price_ok', 'Цена успешно изенена.');
                    return $this->refresh();
                }else{
                    Yii::$app->getSession()->setFlash('edit_items_price_err', 'Что то пошло не тьак. Цена не изенена.');
                    return $this->refresh();
                }
            }else{
                Yii::$app->getSession()->setFlash('edit_items_price_err', 'Что то пошло не тьак. Цена не изенена.');
                return $this->refresh();
            }
        }else{
            if($model)
            {
                return $this->render('editPrice',[
                    'model' => $model[$propreliation][0]
                ]);
            }else{
                Yii::$app->getSession()->setFlash('edit_items_find_err', 'Товар не найден.');
                return $this->redirect(Url::toRoute('get-my-moderation-items'));
            }
        }
    }
}

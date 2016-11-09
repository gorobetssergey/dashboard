<?php

namespace app\controllers;


use app\models\globals\GlobalTables;
use app\models\Moderation;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use Yii;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin_layout';
    private $model;

    public function actionIndex()
    {
        return $this->render('index',[
            'items_moderation' => (new Moderation([]))->getAllItems(true),
        ]);
    }

    public function actionModeration()
    {
        $data = new Moderation();

        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post()["ItemsTransport"];
            if(isset($post['solve']) && $post['solve'] == 'solve')
            {
                if($data->ok($this->findModelItems($post['id'])))
                {
                    Yii::$app->getSession()->setFlash('moderation_ok', 'Использование товара разрешено.');
                    return $this->refresh();
                }
            }elseif(!empty($post['rejection_reason'])){
                Yii::$app->getSession()->setFlash('moderation_no', 'Товар запрещен.');
                return $this->refresh();
            }
        }

        return $this->render('moderation',[
            'items_moderation' => (new Moderation([]))->getAllItems(false),
            'dataProvider' => $data->getProvider()
        ]);
    }

    public function actionViewItems($id)
    {
        $model = $this->findModelItems($id);
        return $this->render('view_items',[
            'model' => (new GlobalTables())->getModel($model->topmenu_id,$model->items_id)
        ]);
    }

    protected function findModelItems($id)
    {
        if (($model = Moderation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

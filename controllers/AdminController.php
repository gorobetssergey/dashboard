<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\globals\GlobalTables;
use app\models\Moderation;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use Yii;
use app\models\Users;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin_layout';
    private $model;
    public function behaviors() {
        if(Yii::$app->user->identity->role==Users::ROLE_ADMIN) {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'index', 'moderation', 'view-items', 'messages'
                            ],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }elseif(Yii::$app->user->identity->role==Users::ROLE_MODERATOR){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'index'
                            ],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }else{
            return [
                'access' => [
                    'rules' => [
                        [
                            'actions' => [],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ];
        }
    }


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
                if($data->no($this->findModelItems($post['id']), $post["rejection_reason"]))
                {
                    Yii::$app->getSession()->setFlash('moderation_no', 'Товар запрещен и отправлен на доработку пользователю.');
                    return $this->refresh();
                }else{
                    Yii::$app->getSession()->setFlash('moderation_err', 'Что-то пошло не так.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('moderation',[
            //'items_moderation' => (new Moderation([]))->getAllItems(false),
            'dataProvider' => $data->getProvider()
        ]);
    }

    public function actionViewItems($id)
    {
        $model = $this->findModelItems($id);
        return $this->render('view_items',[
            'model' => (new GlobalTables())->getModel($model->topmenu_id,$model->items_id),
            'id' => $model->id
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

    public function actionMessages()
    {
        return $this->render('messages');
    }
}

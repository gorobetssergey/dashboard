<?php

namespace app\controllers;


use app\models\Locality;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\globals\GlobalTables;
use app\models\globals\UploadForm;
use app\models\Items;
use app\models\Moderation;
use app\models\ModerationMistake;
use app\models\Users;
use Yii;
use yii\helpers\Url;
use app\models\Profile;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CabinetController extends Controller
{
    public $layout = 'cabinet_layout';

    public function behaviors() {
        if(Yii::$app->user->identity->role==Users::ROLE_USER) {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'index', 'moderation', 'new-items', 'messages', 'add-new-items', 'get-my-active-items','get-my-moderation-items', 'get-my-mistake-items' ,'edit-items', 'profile'
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
        $user = Users::id();
        return $this->render('index',[
            'items_moderation' => (new Moderation([]))->getItems($user),
            'all_items' => (new Items())->getItems($user),
            'moderation_er' => (new ModerationMistake())->getItems($user)
        ]);
    }

    public function actionModeration()
    {
        return $this->render('moderation');
    }

    public function actionNewItems()
    {

        if($this->findProfile(Users::id())->ownership == Profile::INCOGNITO){
            Yii::$app->getSession()->setFlash('profile_successfully' , ['text' => 'Ошибка!!! Для возможности подавать заявки измените данные профиля.', 'color' => 'alert-info']);
            return $this->redirect(Url::home(true).'cabinet/profile');
        }
        return $this->render('newItem');
    }

    public function actionAddNewItems($catalog)
    {
        $params = (new GlobalTables(['catalog' => $catalog]))->getParams();
        $items = new Items(['scenario' =>$params['scenario']]);
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $upload = new UploadForm();
            $upload->titleImage = UploadedFile::getInstance($items, 'titleImage');
            
            $post['Items']['titleImage'] = $upload->titleImage;
            if($items->load($post) && $items->validate())
            {
                $time = time();
                $date = date('Y-m-d H:i:s',strtotime('now'));
                $attributeNames = [
                    'user_id' => Users::id(),
                    'catalog_id' => $catalog,
                    'topmenu_id' => $params['topmenu'],
                    'prop_group' => $catalog,
                    'created_at' => $date,
                    'updated_at' => $date,
                    'status' => Items::STATUS_DEFAULT,
                    'dataitems' => ['topmenu_id'=>$params['topmenu'],'name'=>$post["Items"]["name_tires"]],
                    'table_properties' => $params['table_properties'],
                    'title_photo' => $upload->titleImage,
                    'items' => $items,
                    'time' => $time
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
            'items' => (new GlobalTables())->getUserItemsInModeration(Users::id())
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
        $model = (new GlobalTables([]))->getModel($tompenu, $id, Users::id());
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

    public function actionProfile()
    {
        $modelProfile = $this->findProfile(Users::id());
        if($modelProfile):
            $modelProfile->setScenario('edit');
            if(Yii::$app->request->post()):
                $post = Yii::$app->request->post();
                if($modelProfile->load($post) && $modelProfile->update()):
                    Yii::$app->getSession()->setFlash('profile_successfully', ['text' => 'Успешно. Профиль успешно отредактирован','color' => 'alert-success']);
                    return $this->redirect(Url::toRoute('index'));
                else:
                    Yii::$app->getSession()->setFlash('profile_successfully' , ['text' => 'Ошибка!!! редактирования не сохранено или нет изменений', 'color' => 'alert-danger']);
                endif;
            endif;
            return $this->render('profile',[
                'model' => $modelProfile,
                'ownership' => $modelProfile->getOwnership(),
                'self_ownership' => Yii::$app->user->identity->profiles[0]['ownership0']->value,
                'locality' => new Locality()
            ]);
        endif;
        return $this->render('profile',[
            'model' => $modelProfile
        ]);
    }

    public function findProfile($id)
    {
        $model = Profile::findOne(['user_id' => $id]);
        if ($model !== null) {
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

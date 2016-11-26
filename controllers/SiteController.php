<?php

namespace app\controllers;

use app\models\globals\GlobalTables;
use app\models\Items;
use app\models\Locality;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use app\models\Users;
use yii\helpers\Url;
use app\models\globals\MailerForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'site_layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		
        $modelItems = new Items();
        $ItemsStandard = $modelItems->showItems(Items::STATUS_STANDART);
        $ItemsVip = $modelItems->showItems(Items::STATUS_VIP);
        $modelStandard = [];
        $modelVip = [];
        foreach ($ItemsStandard as $item) {
            $modelStandard[$item->id] = $modelItems->getPath($item->topmenu_id).'/'.$item->topmenu->getPhotoTransports()->where(['item_id'=>$item->items_id])->one()->title;
        }
        foreach ($ItemsVip as $item) {
            $modelVip[$item->id] = $modelItems->getPath($item->topmenu_id).'/'.$item->topmenu->getPhotoTransports()->where(['item_id'=>$item->items_id])->one()->title;
        }
        return $this->render('index',[
            'ItemsVip' => $ItemsVip,
            'modelVip' => $modelVip,
            'ItemsTop' => $modelItems->showItems(Items::STATUS_TOP),
            'ItemsStandard' => $ItemsStandard,
            'modelStandard'=> $modelStandard
        ]);
    }

    public function actionReg()
    {
        $model = new Users(['scenario' => 'registration']);

        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if($model->load($post) && $model->validate()):
                if($user = $model->reg()):
                    if($user->active === Users::STATUS_ACTIVE ):
                        if(Yii::$app->getUser()->login($user)):
                            return $this->redirect('/cabinet/profile');
                        endif;
                    endif;
                endif;
            endif;
        }

        return $this->render('reg',[
            'model' => $model
        ]);
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->role == Users::ROLE_USER){
                return $this->redirect(Url::home(true).'cabinet/index');
            }
            elseif(Yii::$app->user->identity->role == Users::ROLE_ADMIN)
            {
                return $this->redirect(Url::home(true).'admin/index');
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->role == Users::ROLE_USER){
                return $this->redirect(Url::home(true).'cabinet/index');
            }
            elseif(Yii::$app->user->identity->role == Users::ROLE_ADMIN)
            {
                return $this->redirect(Url::home(true).'admin/index');
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionView($items)
    {
        $model_mailer = new MailerForm();
        $model = $this->findModel($items);
        $data = (new GlobalTables())->getModel($model->topmenu_id,$model->items_id);
        $countModel = count($data->transportProps);

        $likeItems = (new GlobalTables())->getLikeItems($model->topmenu_id,$model->items_id);

        $modelStandard = (new GlobalTables())->getPhoto($model->topmenu_id,$model->items_id);
        if ($model_mailer->load(Yii::$app->request->post()) && $model_mailer->sendEmail()) {
            Yii::$app->getSession()->setFlash('profile_successfully', ['text' => 'Успешно. Профиль успешно отредактирован','color' => 'alert-success']);
            return $this->refresh();
        }
        return $this->render('view',[
            'model' => $data,
            'photo' => $modelStandard,
            'mailer' => $model_mailer,
            'countModel' => $countModel,
            'description' => $data->transportProps[$countModel-2]->value,
            'data' =>$likeItems
        ]);
    }

    protected function findModel($id)
    {
        $model = Items::findOne($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetTown($s = null)
    {
        return Locality::returnetown($s);
    }

    public function actionGetName($s = null)
    {
        return Items::returnename($s);
    }

    public function actionFindLikeItems()
    {
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $data = (new Items())->findLikeItems($post['Items']['name'],$post['Locality']['title']);
            return $this->render('afterSearch',[
               'model' => $data 
            ]);
        }else{
            return $this->redirect(Url::toRoute('index'));
        }
    }
}

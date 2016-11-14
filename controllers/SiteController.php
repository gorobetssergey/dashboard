<?php

namespace app\controllers;

use app\models\globals\GlobalTables;
use app\models\Items;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use app\models\Users;

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
        $modelStandard = [];
        foreach ($ItemsStandard as $item) {
            $modelStandard[$item->id] = $modelItems->getPath($item->topmenu_id).'/'.$item->topmenu->getPhotoTransports()->where(['item_id'=>$item->items_id])->one()->title;
        }
        return $this->render('index',[
            'ItemsVip' => $modelItems->showItems(Items::STATUS_VIP),
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
                return $this->redirect('/cabinet/index');
            }
            elseif(Yii::$app->user->identity->role == Users::ROLE_ADMIN)
            {
                return $this->redirect('/admin/index');
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->role == Users::ROLE_USER){
                return $this->redirect('/cabinet/index');
            }
            elseif(Yii::$app->user->identity->role == Users::ROLE_ADMIN)
            {
                return $this->redirect('/admin/index');
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
        $model = $this->findModel($items);
        $data = (new GlobalTables())->getModel($model->topmenu_id,$model->items_id);

        $modelStandard = (new GlobalTables())->getPhoto($model->topmenu_id,$model->items_id);
        return $this->render('view',[
            'model' => $data,
            'photo' => $modelStandard
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
}

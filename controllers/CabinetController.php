<?php

namespace app\controllers;

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
    public function actionModeration()
    {
        return $this->render('moderation');
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
            $upload = new UploadForm();
            $upload->titleImage = UploadedFile::getInstance($items, 'titleImage');
            
            $post['Items']['titleImage'] = $upload->titleImage;
            if($items->load($post) && $items->validate())
            {
                $time = time();
                $date = date('Y-m-d H:i:s',strtotime('now'));
                $attributeNames = [
                    'user_id' => 1,//Yii::$app->user->identity->id,
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
                if($params['table']->save(true,$attributeNames) && $items->uploadTitle($params['topmenu'], $upload->titleImage, $time))
                {
                    Yii::$app->getSession()->setFlash('add_new_items_ok', 'Товар успешно направлен на модерацию.');
                    return $this->refresh();
                }
                else{

                    Yii::$app->getSession()->setFlash('add_new_items_err', 'Ошибка данных.');
                    return $this->refresh();
                }
            }else{var_dump($items->errors);die();
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

    public function actionProfile()
    {
        $modelProfile = new Profile();
        $id = 1;

        if(Yii::$app->request->post()){
            $model = Yii::$app->request->post();
            $res = $modelProfile->updateProfile($model['Profile']);
            if($res == true){
                Yii::$app->getSession()->setFlash('profile_successfully', 'Успешно. Профиль успешно отредактирован');
                Yii::$app->getSession()->setFlash('profile_color', 'alert-success');
            }
            else{
                Yii::$app->getSession()->setFlash('profile_successfully', 'Ошибка!!! редактирования не сохранено или нет изменений');
                Yii::$app->getSession()->setFlash('profile_color', 'alert-danger');
            }
            return $this->redirect('/cabinet');
        }
        else{
            $model = $modelProfile->getForm($id);
            $model->setScenario('edit');
        }
        return $this->render('profile',[
            'model' => $model
        ]);
    }
    /* Registration  */
    public function actionSign_up()
    {
        $model = new Users();
        $model->setScenario('user_reg');

        if(Yii::$app->request->post()){
            $save_model = Yii::$app->request->post();

                if($model->registrationUser($save_model['Users']) && $this->checkModel($save_model['Users'])){
                    return $this->redirect('/cabinet/login');
                }

        }
        return $this->render('registration/sign_up',[
            'model' => $model
        ]);
    }
    private function checkModel($save_model)
    {
        $modelUsers = new Users();
        $res1 = false;
        $res2 = false;
        $error = '';
//        if($save_model['password'] == $save_model['repassword']){
//            $error .=  Yii::t('cabinet', ['registration_error']['password_equal']);
//        }
//        else{
            $res1 = true;
//        }
        if($modelUsers->existEmail($save_model['Users']['email'])){
            $error .= ' '.Yii::t('cabinet', ['registration_error']['email_busy']);
            var_dump('pass busy'); die();

        }
        else{
            $res2 = true;
        }
        if($res1 && $res2){

            return true;
        }
        else{
            Yii::$app->getSession()->setFlash('registration_error', 'werwerwerwerwerwrwrewer');

            return false;
        }
    }

    public function actionLogin()
    {
        return $this->render('registration/login');
    }
    /* Registration END */
}

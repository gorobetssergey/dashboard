<?php

namespace app\controllers;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin_layout';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionModeration()
    {
        return $this->render('moderation');
    }

    public function actionMessages()
    {
        return $this->render('messages');
    }

}

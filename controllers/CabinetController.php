<?php

namespace app\controllers;

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

}

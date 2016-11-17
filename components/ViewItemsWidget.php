<?php

namespace app\components;

use yii\base\Widget;

class ViewItemsWidget extends Widget
{
    public $model;
    public $photo;
    public $countModel;
    public $description;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        return $this->render('viewItems',[
            'photo' => $this->photo,
            'model' => $this->model,
            'countModel' => $this->countModel,
            'description' => $this->description
        ]);
    }
}
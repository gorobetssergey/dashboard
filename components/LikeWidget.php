<?php

namespace app\components;

use yii\base\Widget;

class LikeWidget extends Widget
{
    public $data;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        return $this->render('like',[
            'data' => $this->data
        ]);
    }
}
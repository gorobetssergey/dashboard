<?php

namespace app\components;

use yii\base\Widget;

class VipItemsWidget extends Widget
{
    public $ItemsVip;
    public $modelVip;
    public $title;
    public $it_style;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        return $this->render('vipItems',[
            'ItemsVip' => $this->ItemsVip,
            'modelVip' => $this->modelVip,
            'title' => $this->title,
            'it_style' => $this->it_style
        ]);
    }
}
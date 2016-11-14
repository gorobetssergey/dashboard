<?php
/**
 * Created by PhpStorm.
 * User: Alpha3
 * Date: 14.11.2016
 * Time: 17:41
 */
namespace app\components;

use yii\base\Widget;

class ClerkWidget extends Widget
{
    public $user_profile;
    public $mailer;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        return $this->render('clerk',[
            'profile' => $this->user_profile->profiles[0],
            'email' => $this->user_profile->email,
            'mailer' => $this->mailer
        ]);
    }
}
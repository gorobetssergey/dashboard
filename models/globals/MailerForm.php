<?php

namespace app\models\globals;

use Yii;
use yii\base\Model;

class MailerForm extends Model
{
    public $fromEmail;
    public $fromName;
    public $toEmail = 'momona@ukr.net';
    public $subject;
    public $body;

    public function rules()
    {
        return [
            [['fromEmail', 'subject', 'body'], 'required'],
            ['fromEmail', 'email'],
            ['toEmail', 'email']
        ];
    }

    public function sendEmail()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose([
                'html' => 'layouts/html'
            ])
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
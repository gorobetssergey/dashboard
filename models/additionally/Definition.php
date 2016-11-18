<?php
namespace app\models\additionally;

use yii\base\Model;
class Definition extends Model
{
    public static $INCOGNITO = 1;
    public static $DELIVERY_all = 1111;
    public static $DELIVERY = [
        'nova poshta' => 1000,
        'Meest Express' => 0100,
    ];
}
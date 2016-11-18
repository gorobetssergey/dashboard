<?php
namespace app\models\additionally;

use yii\base\Model;
class Definition extends Model
{
    public static $INCOGNITO = 1;
    public static $DELIVERY_all = 1111;
    public static $DELIVERY = [
        'nova_poshta' => 1000,
        'meest_express' => 0100,
    ];

}
<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DbseedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */

    public $sql;
    public function actionIndex()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            Yii::$app->db->createCommand()->batchInsert('topmenu', ['title'], [
                ['transport'],
                ['real_estate'],
                ['child_world'],
                ['job'],
                ['animals'],
                ['house_garden'],
                ['electronics'],
                ['business_and_services'],
                ['fashion_style'],
                ['sport'],
                ['helping'],
                ['giveAwey'],
                ['exchange'],
            ])->execute();

            Yii::$app->db->createCommand()->batchInsert('submenu', ['title'], [
                ['tires_and_wheels'],
                ['spare_parts_for_speciale'],
                ['cars'],
                ['motozapchastey_and_accessories'],
                ['motorcycles'],
                ['agriculture'],
                ['trucks'],
                ['buses'],
                ['spesial_tehnik'],
                ['air_transport'],
                ['woter_transpotr'],
                ['other_transport'] ,
                ['trailers'],
                ['spec_acessories'],
                ['spare_parts'],
            ])->execute();

            $submenu = (new \yii\db\Query())
                ->select('id')
                ->from('submenu')
                ->all();

            $top_cab = [];
            foreach ($submenu as $item) {
                $top_cab[] = [1,(int)$item['id']];
            }
            Yii::$app->db->createCommand()->batchInsert('top_sub', ['id_top','id_sub'], $top_cab)->execute();;

            Yii::$app->db->createCommand()->batchInsert('catalog', ['title'], [
                ['Tires'],
                ['Discs'],
                ['Complete_wheels'],
                ['Covers'],
                ['motorcycle_tires'],
            ])->execute();
            $catalog = (new \yii\db\Query())
                ->select('id')
                ->from('catalog')
                ->all();
            $cat_cab = [];
            foreach ($catalog as $item) {
                $cat_cab[] = [1,(int)$item['id']];
            }
            Yii::$app->db->createCommand()->batchInsert('sub_cat', ['id_sub','id_cat'], $cat_cab)->execute();

            Yii::$app->db->createCommand()->batchInsert('properties', ['name'], [
                ['price_tires'],
                ['brand_name_tires'],
                ['season_tires'],
                ['width_tires'],
                ['side_view_tires'],
                ['diameter_tires'],
                ['car_type_tires'],
                ['thorns_tires'],
                ['can_thorns_tires'],
                ['descriptions_tires'],
                ['name_tires']
            ])->execute();

            $properties = (new \yii\db\Query())
                ->select('id')
                ->from('properties')
                ->all();
            $prop_group = [];
            foreach ($properties as $item) {
                $prop_group[] = [1,(int)$item['id']];
            }
            Yii::$app->db->createCommand()->batchInsert('properties_group', ['groups','prop_id'], $prop_group)->execute();


            Yii::$app->db->createCommand()->batchInsert('role', ['value'], [
                ['user'],
                ['admin'],
                ['moderator']
            ])->execute();

            /**
             * status items
             */

            Yii::$app->db->createCommand()->batchInsert('status_items', ['status'], [
                ['vip'],
                ['top'],
                ['standart']
            ])->execute();

            /**
             * ounership user
             */

            Yii::$app->db->createCommand()->batchInsert('ownership', ['value'], [
                ['incognito'],
                ['user'],
                ['entity'],
                ['individual']
            ])->execute();

            /*
             * test data to table user
             */


//            Yii::$app->db->createCommand()->batchInsert('users', ['email','role','active','password','repassword','token','created','auth'], [
//                ['user@user.net',1,1,'qqqqqqqq','wwwwwwww','eeeeeeee','2016-10-12 23:00:00',1]
//            ])->execute();

            Yii::$app->db->createCommand()->batchInsert('level', ['value'], [
                ['bonus'],
                ['user'],
                ['junior'],
                ['middle'],
                ['senior'],
                ['top'],
                ['vip'],
                ['menedger'],
                ['boss'],
                ['prezident'],
            ])->execute();

            $transaction->commit();

        } catch(\Exception $e) {

            $transaction->rollBack();

            throw $e;
        }
    }
}

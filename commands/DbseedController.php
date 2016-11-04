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
            ])->execute();

            $transaction->commit();

        } catch(\Exception $e) {

            $transaction->rollBack();

            throw $e;
        }
    }
}

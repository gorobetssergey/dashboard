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
class Dbseed2Controller extends Controller
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
            Yii::$app->db->createCommand()->batchInsert('ownership', ['value'], [
                ['incognito'],
                ['user'],
                ['entity'],
                ['individual']
            ])->execute();

            $transaction->commit();
            echo "Ok! Table ownership updated, need only delete old rows and numeric with 1 number id for new rows\n";

        } catch(\Exception $e) {

            $transaction->rollBack();

            throw $e;
        }
    }
}

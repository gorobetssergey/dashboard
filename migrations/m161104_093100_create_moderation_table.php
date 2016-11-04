<?php

use yii\db\Migration;

/**
 * Handles the creation of table `moderation`.
 */
class m161104_093100_create_moderation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('moderation', [
            'id' => $this->primaryKey(),
            'id_board' => $this->integer(),
            'status' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('moderation');
    }
}

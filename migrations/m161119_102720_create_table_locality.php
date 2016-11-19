<?php

use yii\db\Migration;

class m161119_102720_create_table_locality extends Migration
{
    public function safeUp()
    {
        $this->createTable('locality', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'abbreviations' => $this->string(3)->null(),
            'parent_id' =>$this->integer()->null(),
            'number' => $this->integer()->null(),
            'type' => $this->string(255)->null()
        ]);
        $this->execute(file_get_contents(__DIR__ . '/locality.sql'));
    }

    public function safeDown()
    {
        $this->dropTable('locality');
    }
}

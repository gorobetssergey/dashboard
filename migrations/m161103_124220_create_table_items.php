<?php

use yii\db\Migration;

class m161103_124220_create_table_items extends Migration
{
    public function safeUp()
    {
        /**
         *create table items - All items in site
         */
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'top_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'idx-items_id_top_id',
            'items',
            'top_id'//items.top_id
        );
        $this->addForeignKey(
            'fk-items_id_top_id',
            'items',//table items
            'top_id',//items.top_id
            'topmenu',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-items_id_top_id',
            'items'
        );
        $this->dropIndex(
            'idx-items_id_top_id',
            'items'
        );
        $this->dropTable('items');
    }

}

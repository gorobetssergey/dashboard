<?php

use yii\db\Migration;

class m161102_220110_create_table_default extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('topmenu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);

        $this->createTable('submenu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);

        $this->createTable('top_sub', [
            'id' => $this->primaryKey(),
            'id_top' => $this->integer(),
            'id_sub' => $this->integer(),
        ]);


        $this->createIndex(
            'idx-top_sub_id_top',
            'top_sub',
            'id_top'
        );

        $this->createIndex(
            'idx-top_sub_id_sub',
            'top_sub',
            'id_sub'
        );

        $this->addForeignKey(
            'fk-top_sub_id_top',
            'top_sub',
            'id_top',
            'topmenu',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-top_sub_id_sub',
            'top_sub',
            'id_sub',
            'submenu',
            'id',
            'CASCADE'
        );

        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);

        $this->createTable('sub_cat', [
            'id' => $this->primaryKey(),
            'id_sub' => $this->integer(),
            'id_cat' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-sub_cat_id_sub',
            'sub_cat',
            'id_sub'
        );
        $this->createIndex(
            'idx-sub_cat_id_cat',
            'sub_cat',
            'id_cat'
        );
        $this->addForeignKey(
            'fk-sub_cat_id_sub',
            'sub_cat',
            'id_sub',
            'submenu',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-sub_cat_id_cat',
            'sub_cat',
            'id_cat',
            'catalog',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-sub_cat_id_cat',
            'sub_cat'
        );
        $this->dropForeignKey(
            'fk-sub_cat_id_sub',
            'sub_cat'
        );
        $this->dropIndex(
            'idx-sub_cat_id_cat',
            'sub_cat'
        );
        $this->dropIndex(
            'idx-sub_cat_id_sub',
            'sub_cat'
        );
        $this->dropForeignKey(
            'fk-top_sub_id_top',
            'top_sub'
        );
        $this->dropForeignKey(
            'fk-top_sub_id_sub',
            'top_sub'
        );
        $this->dropIndex(
            'idx-top_sub_id_top',
            'top_sub'
        );
        $this->dropIndex(
            'idx-top_sub_id_sub',
            'top_sub'
        );

        $this->dropTable('topmenu');
        $this->dropTable('submenu');
        $this->dropTable('top_sub');
        $this->dropTable('catalog');
        $this->dropTable('sub_cat');

    }
}
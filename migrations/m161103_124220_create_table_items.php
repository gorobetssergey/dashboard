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
            'topmenu_id' => $this->integer()->notNull(),//referense to table topmenu //tommenu.id
            'items_id' => $this->integer()->notNull(),//referense to table_items this topmenu //tommenu.id
            'name' => $this->string(50)->notNull()//equally table_items this topmenu namepropperty
        ]);
        $this->createIndex(
            'idx-items_id_top_id',
            'items',
            'topmenu_id'//items.top_id
        );

        $this->addForeignKey(
            'fk-items_id_top_id',
            'items',//table items
            'topmenu_id',//items.top_id
            'topmenu',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         *
         */

        $this->createTable('properties',[
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
        ]);
        /**
         *
         */

        $this->createTable('transport_prop',[
            'id' => $this->primaryKey(),
            'items_id' => $this->integer()->notNull(),
            'prop_id' => $this->integer()->notNull(),
            'value' => $this->string(50)->notNull(),
        ]);
        $this->createIndex(
            'idx-items_id_transport_prop',
            'transport_prop',
            'items_id'//items.top_id
        );
        $this->createIndex(
            'idx-prop_id_transport_prop',
            'transport_prop',
            'prop_id'//items.top_id
        );
        $this->addForeignKey(
            'fk-prop_id_transport_prop',
            'transport_prop',//table items
            'prop_id',//items.top_id
            'properties',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         *
         */

        $this->createTable('properties_group',[
            'id' => $this->primaryKey(),
            'groups' => $this->integer(),
            'prop_id' => $this->integer()->notNull()
        ]);
        $this->createIndex(
            'idx-items_id_properties_group',
            'properties_group',
            'prop_id'//items.top_id
        );
        $this->createIndex(
            'idx-group_properties_group',
            'properties_group',
            'groups'//items.top_id
        );
        $this->addForeignKey(
            'fk-items_id_properties_group',
            'properties_group',//table items
            'prop_id',//items.top_id
            'properties',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         *
         */
        $this->createTable('items_transport', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'catalog_id' => $this->integer()->notNull(),
            'topmenu_id' => $this->integer()->notNull(),
            'prop_group' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'description' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
        ]);
        $this->createIndex(
            'idx-user_id_items_transport',
            'items_transport',
            'user_id'
        );
        $this->addForeignKey(
            'fk-user_id_items_transport',
            'items_transport',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-catalog_id_items_transport',
            'items_transport',
            'catalog_id'
        );
        $this->addForeignKey(
            'fk-catalog_id_items_transport',
            'items_transport',//table items
            'catalog_id',//items.top_id
            'catalog',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-topmenu_id_items_transport',
            'items_transport',
            'topmenu_id'
        );
        $this->addForeignKey(
            'fk-topmenu_id_items_transport',
            'items_transport',//table items
            'topmenu_id',//items.top_id
            'topmenu',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-prop_group_items_transport',
            'items_transport',
            'prop_group'
        );
        $this->addForeignKey(
            'fk-prop_group_items_transport',
            'items_transport',//table items
            'prop_group',//items.top_id
            'properties_group',//table topmenu
            'groups',//topmenu.id
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-items_id_transport_prop',
            'transport_prop',//table items
            'items_id',//items.top_id
            'items_transport',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         *
         */
        $this->createTable('level',[
            'id' => $this->primaryKey(),
            'value' => $this->string(50)
        ]);

        /***
         *
         */

        $this->createTable('profile',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tel_first' => $this->string(20)->notNull(),
            'tel_sec' => $this->string(20)->defaultValue(''),
            'tel_next' => $this->string(20)->defaultValue(''),
            'name' => $this->string(50)->defaultValue('ded'),
            'surname' => $this->string(50)->defaultValue('mozay'),
            'patronymic' => $this->string(50)->defaultValue('klaus'),
            'city' => $this->string(50)->defaultValue('Atlantida'),
            'level' => $this->integer()->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-user_id_profile',
            'profile',
            'user_id'
        );
        $this->addForeignKey(
            'fk-user_id_profile',
            'profile',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-level_profile',
            'profile',
            'level'
        );
        $this->addForeignKey(
            'fk-level_profile',
            'profile',//table items
            'level',//items.top_id
            'level',//table topmenu
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

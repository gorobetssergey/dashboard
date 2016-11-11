<?php

use yii\db\Migration;

class m161103_124220_create_table_items extends Migration
{
    public function safeUp()
    {
        /**
         * status items top/vip/standart
         */
        $this->createTable('status_items', [
            'id' => $this->primaryKey(),
            'status' => $this->string(20)->notNull(),
        ]);
        /**
         *create table items - All items in site
         */
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),//referense to table topmenu //tommenu.id
            'topmenu_id' => $this->integer()->notNull(),//referense to table topmenu //tommenu.id
            'items_id' => $this->integer()->notNull(),//referense to table_items this topmenu //tommenu.id
            'name' => $this->string(50)->notNull(),//equally table_items this topmenu namepropperty
            'status' => $this->integer()->notNull(),//referense to status_items status_items.id
            'queue' => $this->integer()->notNull()//output queue items
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
        $this->createIndex(
            'idx-user_id_items',
            'items',
            'user_id'//items.top_id
        );
        $this->addForeignKey(
            'fk-user_id_items',
            'items',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-items_status',
            'items',
            'status'//items.top_id
        );
        $this->addForeignKey(
            'fk-items_status',
            'items',//table items
            'status',//items.status
            'status_items',//table status_items
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
        $this->createTable('photo', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'topmenu_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->null(),
            'photo_1' => $this->string(100)->null(),
            'photo_2' => $this->string(100)->null(),
            'photo_3' => $this->string(100)->null(),
            'photo_4' => $this->string(100)->null(),
            'photo_5' => $this->string(100)->null(),
            'photo_6' => $this->string(100)->null(),
            'photo_7' => $this->string(100)->null(),
            'photo_8' => $this->string(100)->null(),
            'photo_9' => $this->string(100)->null(),
            'photo_10' => $this->string(100)->null(),
        ]);
        $this->createIndex(
            'idx-user_id_photo',
            'photo',
            'user_id'
        );
        $this->addForeignKey(
            'fk-user_id_photo',
            'photo',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-topmenu_id_photo',
            'photo',
            'topmenu_id'
        );
        $this->addForeignKey(
            'fk-topmenu_id_photo',
            'photo',//table items
            'topmenu_id',//items.top_id
            'topmenu',//table topmenu
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
            'photo' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'description' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
        ]);
        $this->createIndex(
            'idx-photo_items_transport',
            'items_transport',
            'photo'
        );
        $this->addForeignKey(
            'fk-photo_items_transport',
            'items_transport',//table items
            'photo',//items.top_id
            'photo',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
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
        /**
         * table ownership
         */
        $this->createTable('ownership',[
            'id' => $this->primaryKey(),
            'value' => $this->string(50)->notNull(),
        ]);

        /***
         *
         */

        $this->createTable('profile',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'ownership' => $this->integer()->notNull(),
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
        $this->createIndex(
            'idx-ownership_profile',
            'profile',
            'ownership'
        );
        $this->addForeignKey(
            'fk-ownership_profile',
            'profile',//table items
            'ownership',//items.top_id
            'ownership',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );

        /**
         *create table moderators - All items to moderators in site
         */
        $this->createTable('moderation', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'topmenu_id' => $this->integer(),//referense to table topmenu //tommenu.id
            'items_id' => $this->integer()->notNull(),//referense to table_items this topmenu //tommenu.id
        ]);
        $this->createIndex(
            'idx-topmenu_id_moderation',
            'moderation',
            'topmenu_id'//items.top_id
        );

        $this->addForeignKey(
            'fk-topmenu_id_moderation',
            'moderation',//table items
            'topmenu_id',//items.top_id
            'topmenu',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-user_id_moderation',
            'moderation',
            'user_id'//items.top_id
        );
        $this->addForeignKey(
            'fk-user_id_moderation',
            'moderation',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         * count items individual user from individual topmenu
         */
        $this->createTable('serviseitems', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'transport' => $this->integer()->notNull()->defaultValue(0),
            'real_estate' => $this->integer()->notNull()->defaultValue(0),
            'child_world' => $this->integer()->notNull()->defaultValue(0),
            'job' => $this->integer()->notNull()->defaultValue(0),
            'animals' => $this->integer()->notNull()->defaultValue(0),
            'house_garden' => $this->integer()->notNull()->defaultValue(0),
            'electronics' => $this->integer()->notNull()->defaultValue(0),
            'business_and_services' => $this->integer()->notNull()->defaultValue(0),
            'fashion_style' => $this->integer()->notNull()->defaultValue(0),
            'sport' => $this->integer()->notNull()->defaultValue(0),
            'helping' => $this->integer()->notNull()->defaultValue(0),
            'giveAwey' => $this->integer()->notNull()->defaultValue(0),
            'exchange' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-user_id_serviseitems',
            'serviseitems',
            'user_id'//items.top_id
        );

        $this->addForeignKey(
            'fk-user_id_serviseitems',
            'serviseitems',//table items
            'user_id',//items.top_id
            'users',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        /**
         * table moderation_mistake - return to user
         */
        $this->createTable('moderation_mistake', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'topmenu_id' => $this->integer(),//referense to table topmenu //tommenu.id
            'items_id' => $this->integer()->notNull(),//referense to table_items this topmenu //tommenu.id
            'descriptions' => $this->string()->notNull(),
        ]);
        $this->createIndex(
            'idx-topmenu_id_moderation_mistake',
            'moderation_mistake',
            'topmenu_id'//items.top_id
        );

        $this->addForeignKey(
            'fk-topmenu_id_moderation_mistake',
            'moderation_mistake',//table items
            'topmenu_id',//items.top_id
            'topmenu',//table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->createIndex(
            'idx-user_id_moderation_mistake',
            'moderation',
            'user_id'//items.top_id
        );
        $this->addForeignKey(
            'fk-user_id_moderation_mistake',
            'moderation_mistake',//table items
            'user_id',//items.top_id
            'users',//table topmenu
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

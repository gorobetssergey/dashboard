<?php

use yii\db\Migration;

class m161102_220110_create_table_default extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        /**
         *create table topmenu - Main menu in site
         */
        $this->createTable('topmenu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);
        /**
         *create table submenu - menu second level in site
         */
        $this->createTable('submenu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);
        /**
         *create table top_sub - relations topmenu with submenu
         */
        $this->createTable('top_sub', [
            'id' => $this->primaryKey(),
            'id_top' => $this->integer()->notNull(),//topmenu.id
            'id_sub' => $this->integer()->notNull(),//submenu.id
        ]);
        /**
         *create table role - role users in site. (admin,user,moderator,guest)
         */
        $this->createTable('role',[
            'id' => $this->primaryKey(),
            'value' => $this->string(10)->defaultValue('user')
        ]);
        /**
         *create table users - registration data.
         */
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(30)->notNull(),//email(login)
            'active' => $this->boolean()->notNull()->defaultValue(true),// active = 1=>allow input, active = 0=>ban in..
            'password' => $this->string(255)->notNull(),//password
            'repassword' => $this->string(255)->notNull(),//repeat password (when you change the password to remember previous)
            'token' => $this->string(255)->notNull(),//personal token
            'role' => $this->integer()->defaultValue(1),//relations role.id
            'created' => $this->dateTime()->notNull(),// data created
            'auth' => $this->boolean()->defaultValue(false)// active ,logged...(prohibition simultaneous input from different browsers and devices)
        ]);
        /**
         *create index table users
         */
        $this->createIndex(
            'idx-users_id_role',
            'users',//table users
            'role'//users.role
        );
        /**
         *create relations table users < -- > role
         */
        $this->addForeignKey(
            'fk-users_id_role',
            'users',
            'role',//users.role
            'role',
            'id',//role.id
            'CASCADE'
        );
        /**
         *create index table top_sub
         */
        $this->createIndex(
            'idx-top_sub_id_top',
            'top_sub',
            'id_top'//top_sub.id_top
        );

        $this->createIndex(
            'idx-top_sub_id_sub',
            'top_sub',
            'id_sub'//top_sub.id_sub
        );
        /**
         *create relations table topmenu < -- > submenu
         */
        $this->addForeignKey(
            'fk-top_sub_id_top',
            'top_sub',//table top_sub
            'id_top',//top_sub.id_top
            'topmenu',////table topmenu
            'id',//topmenu.id
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-top_sub_id_sub',
            'top_sub',//table top_sub
            'id_sub',//top_sub.id_sub
            'submenu',//table submenu
            'id',//submenu.id
            'CASCADE'
        );
        /**
         *create table catalog - third level menu in site (topmenu->submenu->catalog)
         */
        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
        ]);
        /**
         *create table catalog - relations table catalog < -- > submenu
         */
        $this->createTable('sub_cat', [
            'id' => $this->primaryKey(),
            'id_sub' => $this->integer(),//submenu.id
            'id_cat' => $this->integer(),//catalog.id
        ]);
        /**
         *create index table sub_cat
         */
        $this->createIndex(
            'idx-sub_cat_id_sub',
            'sub_cat',
            'id_sub'//sub_cat.id_sub
        );
        $this->createIndex(
            'idx-sub_cat_id_cat',
            'sub_cat',
            'id_cat'//sub_cat.id_cat
        );
        /**
         *create relations table catalog < -- > submenu
         */
        $this->addForeignKey(
            'fk-sub_cat_id_sub',
            'sub_cat',//table sub_cat
            'id_sub',//sub_cat.id_sub
            'submenu',//table submenu
            'id',//submenu.id
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-sub_cat_id_cat',
            'sub_cat',//table sub_cat
            'id_cat',//sub_cat.id_cat
            'catalog',//table catalog
            'id',//catalog.id
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-users_id_role',
            'users'
        );
        $this->dropIndex(
            'idx-users_id_role',
            'users'
        );
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
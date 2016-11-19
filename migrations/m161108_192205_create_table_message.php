<?php

use yii\db\Migration;

class m161108_192205_create_table_message extends Migration
{
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'to_user' => $this->integer(),
            'date' => $this->dateTime(),
            'text' =>$this->text(),
            'reviewed' => $this->boolean(),
            'type' => $this->integer() 
        ]);
        $this->addForeignKey(
            'fk-users_id_messages',
            'messages',//table messages
            'to_user',//messages.to_user
            'users',//table users
            'id',//users.id
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-users_id_messages',
            'messages'//table items
        );
        $this->dropTable('messages');
    }    
}

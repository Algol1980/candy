<?php

use yii\db\Migration;

class m160801_170156_init extends Migration
{
    public function up()
    {
        $this->createTable('user', [
           'id' => $this->primaryKey(),
            'first_name' => $this->string(64),
            'last_name' => $this->string(64),
            'email' => $this->string(64)->notNull(),
            'password' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createTable('candy', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'price' => $this->float(),
            'description' => $this->text(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createTable('rate', [
            'user_id' => $this->integer(),
            'candy_id' => $this->integer(),
            'value' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->addPrimaryKey('pk_rate', 'rate', [ 'user_id',  'candy_id']);
        $this->addForeignKey('fk_user_rate', 'rate', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_candy_rate', 'rate', 'candy_id', 'candy', 'id', 'CASCADE', 'CASCADE');


    }

    public function down()
    {
        $this->dropTable('rate');
        $this->dropTable('candy');
        $this->dropTable('user');

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

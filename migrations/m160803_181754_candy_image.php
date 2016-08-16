<?php

use yii\db\Migration;

class m160803_181754_candy_image extends Migration
{
    public function up()
    {
        $this->addColumn('candy', 'image', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('candy', 'image');
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

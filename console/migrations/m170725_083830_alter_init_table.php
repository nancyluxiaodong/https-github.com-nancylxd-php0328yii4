<?php

use yii\db\Migration;

class m170725_083830_alter_init_table extends Migration
{
    public function up()
    {
        $this->addColumn('user','last_login_time','integer');
        $this->addColumn('user','last_login_ip','integer');
    }

    public function down()
    {
        echo "m170725_083830_alter_init_table cannot be reverted.\n";

        return false;
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

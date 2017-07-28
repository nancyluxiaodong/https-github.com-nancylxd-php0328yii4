<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170724_060646_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull()->comment('身份验证'),
            'password_hash' => $this->string()->notNull()->comment('哈西密码'),
            'password_reset_token' => $this->string()->unique()->comment('确认密码'),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('修改时间'),
            'last_login_time' => $this ->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->string()->comment('最后登录ip'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}

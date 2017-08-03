<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170729_034744_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->comment('用户名'),
//username	varchar(50)	用户名
            'auth_key'=>$this->string(32),
//auth_key	varchar(32)
            'password_hash'=>$this->string(100)->comment('密文'),
//password_hash	varchar(100)	密码（密文）
            'email'=>$this->string(100)->comment('邮箱'),
//            email	varchar(100)	邮箱
            'tel'=>$this->string(11)->comment('电话'),
//tel	char(11)	电话
            'lase_login_time'=>$this->integer(),
//last_login_time	int	最后登录时间
            'last_login_ip'=>$this->integer(),
//last_login_ip	int	最后登录ip
            'status'=>$this->smallInteger(),
//status	int(1)	状态（1正常，0删除）
            'created_at'=>$this->integer(),
//created_at	int	添加时间
            'updated_at'=>$this->integer(),
//updated_at	int	修改时间
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170728_030432_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->text()->comment('名称'),
            'parent_id'=>$this->integer()->comment('上级菜单'),
            'permission'=>$this->text()->comment('权限(路由)'),
            'sort'=>$this->integer()->comment('排序'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}

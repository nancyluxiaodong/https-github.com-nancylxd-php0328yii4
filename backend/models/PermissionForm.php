<?php
namespace backend\models;

use yii\base\Model;

class PermissionForm extends Model{
    public $name;
    public $description;
    //定义场景
    const SCENARIO_ADD = 'add';
    //验证规则
    public function rules(){
        return [
            [['name','description'],'required'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
        ];
}
    public function validateName()
    {
        $authManager = \Yii::$app->authManager;
        if($authManager->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }

    }

    //
    public function attributeLabels()
    {
        return [
           'name'=>'名称(路由)',
            'description'=>'描述',
        ];
    }
}
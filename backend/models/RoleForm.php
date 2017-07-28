<?php
namespace backend\models;

use yii\base\Model;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    //定义场景
    const SCENARIO_ADD = 'add';

    public function rules(){
        return [
            [['name','description'],'required'],
            ['permissions','safe'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
        ];
    }
    public function validateName()
    {
        $role = \Yii::$app->authManager;
        if($role->getRole($this->name)){
            $this->addError('name','角色已存在');
        }

    }
    public function attributeLabels()
    {
        return [
            'name'=>'角色名',
            'description' => '描述',
            'permissions'=>'权限名'
        ];
    }

}
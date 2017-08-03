<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class RbacController extends \yii\web\Controller
{
    //权限列表
    public function actionIndexPermission(){

        //获取所有权限
        $authManager = \Yii::$app->authManager;
        $models = $authManager ->getPermissions();
        //显示页面
        return $this->render('index-permission',['models'=>$models]);
    }
    //添加权限
    public function actionAddPermission(){
        $model = new PermissionForm();
        $model ->scenario = PermissionForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager = \Yii::$app->authManager;
            //创建权限
            $permission = $authManager->createPermission($model->name);
            $permission -> description = $model->description;
            //保存到数据库
            $authManager->add($permission);
            \Yii::$app->session->setFlash('success','添加权限成功');
            return $this->redirect(['rbac/index-permission']);
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    //修改权限
    public function actionEditPermission($name)
    {
        //检查权限是否存在
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        if ($permission == null) {
            throw new NotFoundHttpException('权限不存在');
        }
        $model = new PermissionForm();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                //将表单中数据赋值给
                $permission->name = $model->name;
                $permission->description = $model->description;
                //更新
                $authManager->update($name,$permission);
                \Yii::$app->session->setFlash('success', '权限修改成功');
                //跳转
                return $this->redirect(['rbac/index-permission']);
            }
        }else{
            //回显数据到表单
            $model->name = $permission->name;
            $model->description = $permission->description;
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    //删除权限
    public function actionDeletePermission($name){
        //检查权限是否存在
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        //$permission = \Yii::$app->authManager->getPermission($name);
        if ($permission == null) {
            throw new NotFoundHttpException('权限不存在');
        }
        $authManager->remove($permission);
        \Yii::$app->session->setFlash('danger','权限删除成功');
        //跳转
        return $this->redirect(['index-permission']);
    }
    //角色增删改查
    //角色列表
    public function actionIndexRole(){
        //获取所有权限
        $authManager = \Yii::$app->authManager;
        $models = $authManager ->getroles();
        //显示页面
        return $this->render('index-role',['models'=>$models]);
    }
    //添加角色
    public function actionAddRole(){
        $model = new RoleForm();
        $model ->scenario = RoleForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
             //创建和保存角色
            //创建角色
            $authManager = \Yii::$app->authManager;
            $role = $authManager->createRole($model->name);
            $role ->description = $model->description;
            //保存角色
            $authManager->add($role);
            //给角色赋予权限
            if(is_array($model->permissions)){
                foreach ($model->permissions as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    if($permission) $authManager->addChild($role,$permission);
                }
            }
            \Yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['index-role']);
        }
         return $this->render('add-role',['model'=>$model]);
    }
    //修改角色
    public function actionEditRole($name){
        $model = new RoleForm();
        $authManager = \Yii::$app->authManager;
        $role = $authManager ->getRole($name);
        //检查角色是否存在
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        //$model->loadData($role);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //修改角色

            $role->name = $model->name;
            $role->description = $model->description;
            //更新
            $authManager->update($name,$role);
            //
                \Yii::$app->session->setFlash('success','角色修改成功');
                return $this->redirect(['index-role']);
            }
        //表单回显
        $permissions = $authManager->getPermissionsByRole($name);
        $model->name = $role->name;
        $model->description = $role->description;
        $model->permissions = ArrayHelper::map($permissions,'name','name');

        return $this->render('add-role',['model'=>$model]);
    }
    public function actionDeleteRole($name){
        //检查角色是否存在
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getrole($name);
        //$permission = \Yii::$app->authManager->getPermission($name);
        if ($role == null) {
            throw new NotFoundHttpException('角色不存在');
        }
        $authManager->remove($role);
        \Yii::$app->session->setFlash('danger','角色删除成功');
        //跳转
        return $this->redirect(['index-role']);
    }
    public function behaviors(){
        return[
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add-article','del-article','view-article'],
            ]
        ];
    }

}

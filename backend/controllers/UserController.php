<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use backend\models\Userupdate;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    //添加管理员
    public function actionAdd()
    {
        $model = new User(['scenario' => User::SCENARIO_ADD]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
            $model->status = 10;
            $model->created_at = time();
            $model->auth_key = \Yii::$app->security->generateRandomString();//自动登录authkey生成
            $model->save();
            //给用户添加角色
            $authManager = \Yii::$app->authManager;
            //var_dump($model->roles);exit;
            if(is_array($model->roles)){
                foreach ($model->roles as $roleName) {
                    $role = $authManager->getrole($roleName);
                    if($role) $authManager->assign($role, $model->id);
                }
            }
            \Yii::$app->session->setFlash('success', '用户添加成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('add', ['model' => $model]);
    }

    //修改管理员
    public function actionEdit($id)
    {
        $model = User::findOne(['id' => $id]);
        if ($model == null) {
            throw new NotFoundHttpException('用户不存在');
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->password) {
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
            }
            $model->updated_at = time();
            $model->save();
            \Yii::$app->session->setFlash('success', '用户修改成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('add', ['model' => $model]);
    }
    //删除管理员
    //管理员列表
    public function actionIndex()
    {
        $query = User::find();
        $pager = new Pagination([
            'totalCount' => $query->count()
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index', ['models' => $models, 'pager' => $pager]);
    }

    //登录用户
    public function actionLogin()
    {
        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_LOGIN]);
        //验证
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->login()) {
                //登录成功，保存到session中
                \Yii::$app->session->setFlash('success', '登录成功');
                //var_dump($model);exit;
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    //注销
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['user/index']);
    }

    //测试
    public function actionUser1()
    {
        var_dump(\Yii::$app->user->isGuest);
    }
//用户修改个人密码
    public function actionUserupdate(){

        $model= new Userupdate();
        if($model->load(\Yii::$app->request->post()) && $model->validate() && $model->update()){
            //登录成功并把提示信息保存到session中并跳转首页
            \Yii::$app-> session->setFlash('success','密码修改成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('userupdate',['model'=>$model]);
    }
}

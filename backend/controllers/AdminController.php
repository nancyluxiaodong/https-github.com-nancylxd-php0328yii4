<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\captcha\CaptchaAction;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models = Admin::find()->all();

        return $this->render('index',['models'=>$models]);
    }
    //添加管理员
    public function actionAdd(){
    //实例
    $model = new Admin();
    //接收并保存
    $request = new Request();
    if($request->isPost){
        $model->load($request->post());
        //var_dump($model);exit;
        if($model->validate()){
            $model-> created_at = time();
            $password_hash = \Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->password_hash=$password_hash;
            //保存到数据库
            //var_dump($model);exit;
            $model->save();
            //跳转页面
            return $this->redirect(['admin/index']);
        }else{
            var_dump($model->getErrors());
        }
    }
    return $this->render('add',['model'=>$model]);
}
    //修改管理员信息
    public function actionEdit($id){
        //实例
        $model = Admin::findOne($id);
        //接收并保存
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //var_dump($model);exit;
            if($model->validate()){
                $model-> updated_at = time(); //date('Y-m-d h:i:s',time());
                //$model ->last_login_ip = $_SERVER["REMOTE_ADDR"];
                $password_hash = \Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->password_hash=$password_hash;
                //保存到数据库
                //var_dump($model);exit;
                $model->save();
                //跳转页面
                return $this->redirect(['admin/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除用户
    public function actionDelete($id){
        $model = Admin::findOne($id);
        $model ->delete();
        return $this->redirect(['admin/index']);
    }
    //登录用户
    public function actionLogin(){
        $model = new LoginForm();
        $request = new Request();
        //验证
        if($request ->isPost){
            $model->load($request->post());
            if($model->validate() && $model->login()){
                //登录成功，保存到session中
               //var_dump($model);exit;
                //var_dump(\Yii::$app->user->identity);exit;
                \Yii::$app->session->setFlash('success','登录成功');
                //var_dump($model);exit;
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }




    //定义验证码操作
    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'minLength'=>4,
                'maxLength'=>4,
            ]
        ];
    }
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessControl::className(),
                //哪些操作需要使用该过滤控制器
                'only'=>['add','delete','edit'],
                'rules'=>[
                    [    //是否允许
                        'allow'=>true,
                        //指定操作
                        'actions'=>['add','delete','edit'],
                        //指定角色 ?表示未认证用户(未登录) @表示已认证用户(已登录)
                        'roles'=>['@'],
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['index'],
                        'matchCallback'=>function(){
                            return !(date('d')%2);
                        }
                    ],
                    //其他均禁止访问
                ]
            ]
        ];
    }
}

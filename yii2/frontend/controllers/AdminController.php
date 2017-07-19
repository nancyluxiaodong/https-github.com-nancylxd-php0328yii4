<?php

namespace frontend\controllers;

use frontend\models\Admin;
use frontend\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    //登录
    public function actionLogin(){
        //1.认证（检查用户账号密码是否正确）
        $model = new LoginForm();
        $request = new Request();
        //验证
        if($request->isPost){
            $model->load($request->post());
            if($model->validate() && $model->login()){
                //登录成功（保存密码到session中）
                \Yii::$app->session->setFlash('session','登录成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionIndex()
    {
        //获取数据
        $model = Admin::find()->all();
        //调用视图
        return $this->render('index',['model'=>$model]);
    }
    //添加功能
    public function actionAdd()
    {   //实例化表单
        $model = new Admin();
        //接收并保存
        $request = new Request();
        //实例化文件上传对象

        if($request->isPost){
            //echo 111;exit;
            $model->load($request->post());
            $model->photoFile = UploadedFile::getInstance($model,'photoFile');
            //验证
            //var_dump($model->photoFile);exit;
            if($model->validate()){
                //echo 111;exit;
                //保存
                $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->photoFile->extension;
                $model->photoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                $model->photo= $fileName;
                $password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->password=$password;
                $model->save(false);
                //跳转页面
                return $this->redirect(['admin/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);
    }
        //修改用户信息
        public function actionDelete($id){
        //根据id查询数据
        $model = Admin::findOne(['id'=>$id]);
        //删除该条数据
        $model->delete();
        //跳转页面
        return $this->redirect(['admin/index']);
    }
    //修改功能
    public function actionEdit($id)
    {   //实例化表单
        $model = Admin::findOne(['id' => $id]);
        //接收并保存
        $request = new Request();
        //实例化文件上传对象
        $model->password = '';
        if ($request->isPost) {
            //echo 111;exit;
            $model->load($request->post());
            $model->photoFile = UploadedFile::getInstance($model, 'photoFile');
            //验证

            if ($model->validate()) {
                //echo 111;exit;
                //保存
                $fileName = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->photoFile->extension;
                $model->photoFile->saveAs(\Yii::getAlias('@webroot') . $fileName, false);
                $model->photo = $fileName;
                $password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->password=$password;
                $model->save();
                //跳转页面
                return $this->redirect(['admin/index']);
            } else {
                var_dump($model->getErrors());
            }
        }
        return $this->render('add', ['model' => $model]);
    }
        public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessControl::className(),
                //哪些操作需要使用该过滤控制器
                'only'=>['add','delete','index','edit'],
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
    //定义验证码操作
    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'minLength'=>3,
                'maxLength'=>3,
            ]
        ];
    }
}

<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\captcha\CaptchaAction;

class MemberController extends \yii\web\Controller
{
    public $layout=false;
    public $enableCsrfValidation = false;
    //注册功能
    public function actionRegister(){
        $model = new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //将密码转换为hash密码保存到数据库
            $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
            $model->created_at = time();
            //自动登录auth_key生成
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->save(false);
            \Yii::$app->session->setFlash('success', '注册成功');
            return $this->redirect(['member/login']);
        }
        return $this->render('register',['model'=>$model]);
    }
    //登录功能
   public function actionLogin(){
       $model = new LoginForm(['scenario' => LoginForm::SCENARIO_LOGIN]);
       //验证
       if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
           //var_dump($model);exit;
           if ($model->login()) {
               //登录成功，保存到session中
               //\Yii::$app->session->setFlash('success', '登录成功');
               //var_dump($model);exit;
               return $this->redirect(['member/address']);
           }
       }
       return $this->render('login', ['model' => $model]);
   }

    public function actionIndex()
    {
        //打印登录状态
        // var_dump(\Yii::$app->user->identity);exit;
        $model = new Member();
        return $this->render('index',['model'=>$model]);
    }
    //收货地址管理
    public function actionAddress(){
       $model = new Address();
       //var_dump($_POST);
        //收货地址管理

       if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->member_id = \Yii::$app->user->id();
            //var_dump($model);exit;
            $model->save();
            //\Yii::$app->session->setFlash('success','地址添加成功');
            return $this->redirect(['member/address']);
       }
       //$address = Address::find()->orderBy('is_default DESC')->limit(3)->all();
       $address = Address::findAll(['member_id'=>\Yii::$app->user->id]);
       return $this->render('address',['model'=>$model,'address'=>$address]);
    }

    //退出登录功能
    public function actionLogout(){
        \Yii::$app->user->logout();
        $model = new LoginForm();
        return $this->redirect('login',['model'=>$model,]);
    }
    public function actionUser()
    {
        //可以通过 Yii::$app->user 获得一个 User实例，
        $user = \Yii::$app->user;
        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = \Yii::$app->user->identity;
        var_dump($identity);

        // 当前用户的ID。 未认证用户则为 Null 。
        $id = \Yii::$app->user->id;
        var_dump($id);
        // 判断当前用户是否是游客（未认证的）
        $isGuest = \Yii::$app->user->isGuest;
        var_dump($isGuest);
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
}

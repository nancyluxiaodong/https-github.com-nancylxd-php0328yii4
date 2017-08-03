<?php
namespace frontend\models;

use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $rememberMe;
    public $code;
    const SCENARIO_LOGIN = 'login';
    public function rules(){
        return [
            [['username','password','code'],'required'],
            [['rememberMe'],'safe','on'=>self::SCENARIO_LOGIN],
            ['code','captcha','captchaAction'=>'member/captcha'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'账户：',
            'password'=>'密码：',
            'code'=>'验证码：',
            'rememberMe'=>''
        ];
    }
    public function login(){
        //通过用户名查找用户
        $member = Member::findOne(['username'=>$this->username]);
        if($member){
            if(\Yii::$app->security->validatePassword($this->password,$member->password_hash)){
                //密码正确.可以登录
                //2 登录(保存用户信息到session)
               \Yii::$app->user->login($member,$this->rememberMe?1*24*3600:0);
                //var_dump(\Yii::$app->user->isGuest);exit;
                $member->lase_login_time = time();
                //$admin->last_login_ip = $_SERVER["REMOTE_ADDR"];
                $member->last_login_ip = ip2long(\Yii::$app->request->userIP);
                $member->save(false);
                return true;
            }else{
                //密码错误.提示错误信息
                $this->addError('password','密码错误');
            }
        }else{
            //用户不存在,提示 用户不存在 错误信息
            $this->addError('username','用户名不存在');
        }
        return false;
    }
}
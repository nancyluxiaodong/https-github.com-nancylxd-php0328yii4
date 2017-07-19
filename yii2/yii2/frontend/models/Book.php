<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/15
 * Time: 21:26
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class Book extends ActiveRecord{
    public $imgFile;
    public $code;//验证码

    //建立于分类表的关系
    public function getCategory(){
//        return $this->hasOne('frontend\models\StudentClass');
        return $this->hasOne(Author::className(),['id'=>'author']);
    }
    //验证规则
    public function rules()
    {
        return [
            [['title','price','status','author','sn','content'],'required'],
            //指定上传文件的验证规则 extensions文件的扩展名（开启php fileinfo扩展）
            // skipOnEmpty 为空跳过该验证
            ['imgFile','file','extensions'=>['jpg','png','gif']/*,'skipOnEmpty'=>false*/],
            //验证码验证规则
            ['code','captcha','captchaAction'=>'book/captcha'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'title'=>'书名',
            'sn'=>'货号',
            'price'=>'价格',
            'author'=>'作者',
            'content'=>'简介',
            'status'=>'是否上架',
            'imgFile'=>'简略图',
            //验证码验证规则

            ];
    }


}
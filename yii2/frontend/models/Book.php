<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public $logoFile;//保存文件上传对象
    public $code;//验证码
        //建立分类表关系
    public function getAuthor(){
        return $this->hasOne(Author::className(),['id'=>'author_id']);
    }
    public function rules()
    {
        //验证规则
        return [
            [['name', 'author_id',  'sn', 'sale_time', 'status', 'intro', 'logoFile'], 'required'],
           ['logoFile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>false],
            ['code','captcha','captchaAction'=>'book/captcha'],
            ['price','string'],
            //验证码验证规则
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => '图书名称',
            'author_id' => '作者',
            'price' => '价格',
            'sn' => '货号',
            'sale_time' => '上架时间',
            'status' => '是否上架',
            'intro' => '图书介绍',
            'logoFile' => '图书封面',
        ];
    }
}
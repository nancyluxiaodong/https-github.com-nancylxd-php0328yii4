<?php
namespace frontend\models;

use yii\base\Model;

class GoodsForm extends Model{
    public $name;
    public $sn;
    public $price;
    public $total;
    public $detail;
    public function rule(){
        return[
            [['name','sn'],'required','message'=>'{attribute}必填'],
            ['price','integer'=>'年龄']
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'商品名称',
            'sn'=>'货号',
            'price'=>'价格',
            'total'=>'库存',
            'detail'=>'简介',
        ];

    }
}
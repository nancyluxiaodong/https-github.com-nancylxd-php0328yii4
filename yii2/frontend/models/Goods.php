<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Goods extends ActiveRecord{

    public function rules(){
        return[
            [['name','sn','price','total','detail'],'required','message'=>'{attribute}必填'],
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
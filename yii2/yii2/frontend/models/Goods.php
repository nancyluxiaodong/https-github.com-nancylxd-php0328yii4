<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/14
 * Time: 18:19
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord{
    //验证规则
    public function rules()
    {
        return [
            [['name','price'],'required','message'=>'{attribute}不能为空'],
            ['price','match','pattern'=>'/^\d+\.\d{2}$/','message'=>'价格必须含两位小数，例如1.00']
        ];
    }
//    public function rules(){
//        return [
//            [['name','price'],'required','message'=>'不能为空']
//        ];
//    }
}
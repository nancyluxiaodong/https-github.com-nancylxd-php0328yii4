<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/13
 * Time: 18:33
 */
namespace frontend\models;
use yii\db\ActiveRecord;
class Student extends ActiveRecord{
    //建立于分类表的关系
    public function getCategory(){
//        return $this->hasOne('frontend\models\StudentClass');
        return $this->hasOne(StudentClass::className(),['id'=>'class']);
    }
    //规则
    public function rules(){
        return [
          [['name','class'],'required','message'=>'不能为空']
        ];
    }
}
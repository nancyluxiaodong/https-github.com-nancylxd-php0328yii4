<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/13
 * Time: 19:28
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class StudentClass extends ActiveRecord{
    //与学生表建立关系
    public function getStudent(){
        return $this->hasMany(Student::className(),['class'=>'id']);
    }
    //这个方法能解决不能创建class数据库
    public static function tableName(){
        return 'class';
    }
    //验证规则
    public function rules()
    {
        return [
            ['name','required','message'=>'{attribute}不能为空']
        ];
    }
}
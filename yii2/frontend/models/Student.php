<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Student extends ActiveRecord
{
    public $imgFile;//保存文件上传对象
    public $code;//验证码

    public function attributeLabels()
    {
        return [
            'name'=>'姓名',
            'age'=>'年龄',
            'imgFile'=>'头像'
        ];
    }

    public function rules()
    {
        return [
            [['name','age'],'required'],
            //指定上传文件的验证规则 extensions文件的扩展名（开启php fileinfo扩展）
            // skipOnEmpty 为空跳过该验证
            ['imgFile','file','extensions'=>['jpg','png','gif']/*,'skipOnEmpty'=>false*/],
            //验证码验证规则
            ['code','captcha','captchaAction'=>'day3/captcha'],
        ];
    }

    //建立和teacher的关联关系  多对多
    public function getTeachers()
    {
        //                      关联对象的类名    关联对象的主键（id） =》 关联对象在中间表的关联id（teacher_id）
        return $this->hasMany(Teacher::className(),['id'=>'teacher_id'])
            //                   中间表的表名  当前对象在中间表的关联id（student_id） =>当前对象的主键（id）
            ->viaTable('teacher_student',['student_id'=>'id']);
    }
}


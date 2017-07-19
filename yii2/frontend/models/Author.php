<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord{
    //与book表建立关系
    public function getBook(){
        return $this->hasMany(Book::className(),['id'=>'author_id']);
    }
    //
    public function rules(){
        return[
            [
                ['name','age','sex','photo','birthday'],'required'
            ],
        ];
    }
    public function attributeLabels(){
        return[
          'name'=>'作者名称',
          'age'=>'年龄',
          'sex'=>'性别',
          'photo'=>'头像',
          'birthday'=>'生日',
        ];
    }
}
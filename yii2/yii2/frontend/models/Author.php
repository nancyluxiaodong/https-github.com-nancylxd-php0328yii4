<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/15
 * Time: 18:12
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class Author extends ActiveRecord{
    public $imgFile;
    //规则
    public function getBook(){
        return $this->hasMany(Book::className(),['author'=>'id']);
    }
    public function rules()
    {
        return [
            [['age','sex','name'],'required'],
            //验证图片类型
//            ['imgFile','file','extensions'=>['jpg','png','gif'],
//                'skipOnEmpty'=>false],
            ['imgFile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>true],
        ];
    }
}
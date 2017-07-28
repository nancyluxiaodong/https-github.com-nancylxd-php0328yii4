<?php
namespace backend\models;

use yii\base\Model;

class ArticleSearchForm extends Model{
    public $name;
    public $intro;
    public $sort;
    public function rules()
    {
        return [
          [['name','intro','sort'],'safe'],
        ];
    }
}
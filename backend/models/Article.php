<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    //建立和文章分类表的关系  1对1
    /*public function getArticleCategory()
    {
        return $this->hasOne(ArticleCategory::className(),
        ['id'=>'article_category_id']);//返回一个对象
    }*/
    //组长的代码
    public  function getArticleCategorys(){
        $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);//hasOne 返回一个对象
        $articleCategory=ArticleCategory::find()->all();
        $articleCategorys=[];
        foreach ($articleCategory as $a){
            $articleCategorys[$a->id]=$a->name;
        }
        return  $articleCategorys;
    }
//    public  function getArticleCategorys()
//    {
//       $all=$this->getArticleCategory()->find()->all();
//        $categorys=[];
//        foreach($all as $a){
//            $categorys[$a->id]= $a->name;
//        }
//        return $categorys;
//
//    }

    /*public static function getStatusOptions($hidden_del=true){
        $options=[
            -1=>'删除',
            0=>'隐藏',
            1=>'正常',
        ];
        if($hidden_del){
            unset($options[-1]);
        }
        return $options;
    }*/
    public static $status_all =[
        0=>'隐藏',
        1=>'正常'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'article_category_id' => '分类',
            'sort' => '排序',
            'status' => '状态',
            'content' => '内容',
            'create_time' => '创建时间',
        ];
    }
}

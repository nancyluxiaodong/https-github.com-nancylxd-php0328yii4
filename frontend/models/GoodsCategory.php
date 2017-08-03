<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class GoodsCategory extends ActiveRecord{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }
    //上级菜单和下级菜单建立一对多关系
    public function getChildren(){
        return $this->hasMany(GoodsCategory::className(),['parent_id'=>'id']);
    }
    //上级菜单和下级菜单建立一对多关系
    public function getChild(){
        return $this->hasMany(GoodsCategory::className(),['parent_id'=>'id']);
    }


}
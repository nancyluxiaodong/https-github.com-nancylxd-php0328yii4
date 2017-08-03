<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $parent_id
 * @property string $permission
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public static function getmenus()
    {
        $array=\yii\helpers\ArrayHelper::map(self::find()->where('parent_id=0')->all(),'id','name');
        $array[0]='==顶级分类==';
        return $array;
    }

    public function rules()
    {
        return [
            [['name', 'parent_id', 'permission'], 'string'],
            [['sort'], 'integer'],
            [['name'],'unique'],
            [['name','parent_id','permission'],'required'],
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
            'parent_id' => '上级菜单',
            'permission' => '权限(路由)',
            'sort' => '排序',
        ];
    }
    //获取子菜单  Menu[]
    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}

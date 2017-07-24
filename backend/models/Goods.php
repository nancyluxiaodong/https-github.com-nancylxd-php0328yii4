<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $view_times
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $sale_options = [
        1 => '上架',2=>'下架',
        ];
    public static $status_options = [
            0=>'回收站',1=>'正常',
        ];
    //建立与商品分类的关系1对多
    public  function getGoodsCategorys(){
        $this->hasOne(GoodsCategory::className(),
        ['id'=>'goods_category_id']);//hasOne 返回一个对象
        $goodsCategory=GoodsCategory::find()->all();
        $goodsCategorys=[];
        foreach ($goodsCategory as $a){
            $goodsCategorys[$a->id]=$a->name;
        }
        return  $goodsCategorys;
    }
    //建立与品牌表的关系1对1
    public  function getBrands(){
        $this->hasOne(Brand::className(),
            ['id'=>'brand_id']);//hasOne 返回一个对象
        $brand=Brand::find()->all();
        $brands=[];
        foreach ($brand as $a){
            $brands[$a->id]=$a->name;
        }
        return  $brands;
    }

    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time', 'view_times'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
            [['name','goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort','logo' ],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'LOGO图片',
            'goods_category_id' => '商品分类id',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
            'view_times' => '浏览次数',
        ];
    }
}

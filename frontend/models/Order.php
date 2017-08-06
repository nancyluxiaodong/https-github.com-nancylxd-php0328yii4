<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $detail
 * @property integer $tel
 * @property integer $delivery_id
 * @property integer $delivery_name
 * @property double $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord

{
    public $price;
    //快递方式
    public static $deliveries=[
        1=>['name'=>'顺丰快递','price'=>'25','detail'=>'速度非常快，服务非常好，价格稍贵'],
        2=>['name'=>'申通快递','price'=>'15','detail'=>'速度快，服务好，价格便宜'],
        3=>['name'=>'EMS','price'=>'12','detail'=>'速度一般，服务好，价格便宜'],
    ];
    //支付方式
    public static $payments=[
        1=>['name'=>'货到付款','detail'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['name'=>'在线支付','detail'=>'即时到账'],
        3=>['name'=>'上门自提','detail'=>'自提时付款，支持现金、POS机刷卡、支票支付'],
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'tel', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['province', 'city', 'county'], 'string', 'max' => 20],
            [['detail', 'payment_name', 'trade_no','delivery_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'county' => '县',
            'detail' => '详细地址',
            'tel' => '电话号码',
            'delivery_id' => '配送方式id',
            'delivery_name' => '配送方式名称',
            'delivery_price' => '配送方式价格',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式名称',
            'total' => '订单金额',
            'status' => '订单状态',
            'trade_no' => '第三方支付交易号',
            'create_time' => '创建时间',
        ];
    }
}

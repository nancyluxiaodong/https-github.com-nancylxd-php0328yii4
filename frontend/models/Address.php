<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $detail
 * @property string $tel
 * @property integer $is_default
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name',  'detail', 'tel','province', 'city', 'county'], 'required'],
            [['member_id', 'is_default'], 'integer'],
            [['name', 'province', 'city', 'county'], 'string', 'max' => 100],
            [['detail'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['member_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '所属用户：',
            'name' => '*收货人：',
            'province' => ' ',
            'city' => ' ',
            'county' => ' ',
            'detail' => '*详细地址：',
            'tel' => '*手机号码：',
            'is_default' => '设为默认地址：',
        ];
    }
}

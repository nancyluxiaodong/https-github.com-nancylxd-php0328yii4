<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Add extends ActiveRecord
{

    public static function tableName()
    {
        return 'admin';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'realname', 'photo', 'age', 'sex'], 'required'],
            [['age'], 'integer'],
            [['username', 'password', 'realname', 'photo', 'sex'], 'string', 'max' => 255],
        ];
    }
}
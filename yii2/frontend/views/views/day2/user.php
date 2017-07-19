<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method'=>'get','id'=>'form',
]);
echo $form->field($model,'name')->textInput();//文本输入框
echo $form->field($model,'age')->textInput();//
echo $form->field($model,'sex')->dropDownList([1=>'男',2=>'女',3=>'不详']);//下拉选择框
echo $form->field($model,'status',['inline'=>1])->radioList([1=>'已婚',2=>'未婚',3=>'离异']);//radio单选
echo $form->field($model,'hobby',['inline'=>1])->checkboxList([1=>'吃饭',2=>'睡觉',3=>'打豆豆']);//多选
echo $form->field($model,'intro')->textarea(['id'=>'intro','rows'=>10]);//文本域

/*$config = [
'label' => '提交',
    'options' => [
    // 按钮的属性部分
    'class' => 'btn btn-danger', // 设置按钮的样式
    'type' => 'submit'	// 设置按钮的类型
    ]
];
\yii\bootstrap\Button::begin($config);
\yii\bootstrap\Button::end();*/
echo \yii\bootstrap\Html::submitButton('提交',[ 'class' => 'btn btn-danger']);
\yii\bootstrap\ActiveForm::end();

//显示图片
echo \yii\bootstrap\Html::img('@web/images/avator.png',['class'=>'img-circle']);
echo \yii\bootstrap\Html::tag('div','这里div里面的内容');
echo '<div>这里div里面的内容</div>';

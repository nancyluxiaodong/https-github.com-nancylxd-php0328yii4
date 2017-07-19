<?php
//使用表单组件配合表单模型生成表单
$form = \yii\bootstrap\ActiveForm::begin();//表单开始
echo $form->field($model,'name')->textInput();// input type=text
echo $form->field($model,'age')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();//表单结束
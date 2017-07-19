<?php
$form = \yii\bootstrap\ActiveForm::begin();//<form>
echo $form->field($model,'name');
echo $form->field($model,'sn');
echo $form->field($model,'price');
echo $form->field($model,'category_id')->dropDownList([1=>'手机',2=>'家电']);
echo $form->field($model,'total');
echo $form->field($model,'detail')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();//</form>

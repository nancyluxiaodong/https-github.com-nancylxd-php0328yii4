<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'age');
echo $form->field($models,'sex');
echo $form->field($models,'photo');
echo $form->field($models,'birthday');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name');
echo $form->field($goods,'price');
echo \yii\bootstrap\Html::submitInput('添加商品',['class'=>'btn']);


\yii\bootstrap\ActiveForm::end();
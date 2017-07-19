<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($rows,'name');
echo \yii\bootstrap\Html::submitInput('立即添加',['class'=>'btn']);
\yii\bootstrap\ActiveForm::end();
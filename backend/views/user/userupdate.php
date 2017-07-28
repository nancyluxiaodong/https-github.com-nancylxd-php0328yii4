<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'oldpassword')->passwordInput();
echo $form->field($model,'newpassword')->passwordInput();
echo $form->field($model,'surepassword')->passwordInput();

echo \yii\bootstrap\Html::submitButton('修改',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();
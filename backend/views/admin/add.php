<h3>注册用户</h3>
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'auth_key');
echo $form->field($model,'password_hash')->passwordInput();
echo $form->field($model,'password_reset_token');
echo $form->field($model,'email');
echo $form->field($model,'status');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();
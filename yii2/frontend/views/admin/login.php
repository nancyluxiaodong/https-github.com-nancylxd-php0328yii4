<?php
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info'],['inline'=>1]);
\yii\bootstrap\ActiveForm::end();
?>
<br>
<?php
echo \yii\bootstrap\Html::a('注册新用户',['admin/add'],['class'=>'btn btn-sm btn-success']);
?>

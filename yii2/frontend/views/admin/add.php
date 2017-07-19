<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password');
echo $form->field($model,'realname');
echo $form->field($model,'age');
echo $form->field($model,'photoFile')->fileInput();
echo $form->field($model,'sex',['inline'=>1])->radioList([1=>'男',2=>'女',3=>'保密']);
//验证码
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'admin/captcha',
        'template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'])->label('验证码');
echo \yii\bootstrap\Html::submitButton('确认注册',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

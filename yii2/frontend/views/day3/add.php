<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'age');
//上传头像
echo $form->field($model,'imgFile')->fileInput();
//验证码
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'day3/captcha',
        'template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'])->label('验证码');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
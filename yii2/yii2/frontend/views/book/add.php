<?php
foreach ($rows as $row){
    $tmp[$row->id]=$row->name;
}

$form=\yii\bootstrap\ActiveForm::begin();//表单开始
echo $form->field($model,'title');
echo $form->field($model,'imgFile')->fileInput(['class'=>'btn']);

if (isset($model->img)){
    //回显图片
    echo \yii\bootstrap\Html::img($model->img,['height'=>40]).'<br/>';
}
echo $form->field($model,'price');
echo $form->field($model,'status',['inline'=>1])->radioList([1=>'上架',2=>'不上架']);
echo $form->field($model,'author')->dropDownList($tmp);
echo $form->field($model,'sn');
echo $form->field($model,'content')->textarea();
//验证码
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'book/captcha',
        'template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'])->label('验证码');
echo \yii\bootstrap\Html::submitButton('添加作者',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();//表单结束
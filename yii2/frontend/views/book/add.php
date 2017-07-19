<?php
//便利author表中的name
/*foreach ($rows as $row){
    $tmp[$row->id]=$row->name;
}*/
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'author_id')/*->dropDownList($tmp)*/;
echo $form->field($model,'price');
echo $form->field($model,'sn');
echo $form->field($model,'sale_time');
echo $form->field($model,'sex',['online'=>1])->radioList([1=>'男',2=>'女',3=>'保密']);

echo $form->field($model,'status',['inline'=>1])->radioList([1=>'上架',2=>'下架',]);
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'logoFile')->fileInput();
//验证码
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'book/captcha',
        'template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'])->label('验证码');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

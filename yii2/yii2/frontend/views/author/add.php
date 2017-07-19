<?php
$form=\yii\bootstrap\ActiveForm::begin();//表单开始
echo $form->field($model,'name');
echo $form->field($model,'age');
echo $form->field($model,'sex',['inline'=>1])->radioList([1=>'男',2=>'女']);

echo $form->field($model,'imgFile')->fileInput(['class'=>'btn']);

if (isset($model->img)){
    //回显图片
    echo \yii\bootstrap\Html::img($model->img,['height'=>40]).'<br/>';
}
echo \yii\bootstrap\Html::submitInput('添加作者',['class'=>'btn']);
\yii\bootstrap\ActiveForm::end();//表单结束
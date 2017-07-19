<?php
//var_dump($rows);exit;
foreach ($rows as $row){
    $tmp[$row->id]=$row->name;
}
//\yii\helpers\ArrayHelper::map($rows,'id','name');
//exit;
//var_dump($row);exit;
$form=\yii\bootstrap\ActiveForm::begin();//表单开始
echo $form->field($model,'name');
echo $form->field($model,'class')->dropDownList($tmp);
echo \yii\bootstrap\Html::submitInput('添加',['class'=>'btn btn-default']);
\yii\bootstrap\ActiveForm::end();//表单结束
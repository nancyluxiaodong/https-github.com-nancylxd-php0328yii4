<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\Brand::getStatusOptions());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();

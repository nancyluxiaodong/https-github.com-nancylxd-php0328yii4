<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email');
if(!$model->isNewRecord){
    echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\User::$status_options);
}
echo $form->field($model,'roles',['inline'=>1])->checkboxList(\yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(),'name','name'));
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();
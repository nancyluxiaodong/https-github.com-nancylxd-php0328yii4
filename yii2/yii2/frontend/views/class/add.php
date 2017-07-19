<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/13
 * Time: 19:48
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($rows,'name');
echo \yii\bootstrap\Html::submitInput('立即添加',['class'=>'btn']);
\yii\bootstrap\ActiveForm::end();
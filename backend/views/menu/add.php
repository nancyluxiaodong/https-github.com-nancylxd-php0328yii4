<h2>添加菜单</h2>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getmenus());
echo $form->field($model,'permission')->dropDownList(\yii\helpers\ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','name'),['prompt' => '=请选择路由=']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
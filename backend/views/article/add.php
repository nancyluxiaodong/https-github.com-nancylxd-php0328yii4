<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')/*->dropDownList(\backend\models\Article::getArticleCategory())*/;
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\Article::$status_all);
echo $form->field($detailmodel,'content')->textarea();
//echo $form->field($detailmodel,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();
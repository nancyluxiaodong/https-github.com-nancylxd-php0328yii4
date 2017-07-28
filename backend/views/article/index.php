<?php
echo \yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-sm btn-info'])
?>
<?php
$form=\yii\bootstrap\ActiveForm::begin([
    'layout'=>'inline','method'=>'get','action'=>['article/index']
]);
echo $form->field($model,'name')->textInput(['placeholder'=>'标题']);
echo $form->field($model,'sort')->textInput(['placeholder'=>'排序']);
echo $form->field($model,'intro')->textInput(['placeholder'=>'简介']);
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-default']);
\yii\bootstrap\ActiveForm::end();
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>文章分类ID</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($articles as $article): ?>
        <tr>
            <td><?=$article->id ?></td>
            <td><?=$article->name ?></td>
            <td><?=$article->intro ?></td>

            <td><?=$article->articleCategorys[$article->article_category_id] ?></td>
            <td><?=$article->sort ?></td>
            <td><?=\backend\models\Article::$status_all[$article->status] ?></td>
            <td><?=date('Y-m-d',$article->create_time)?></td>
            <td> <?=\yii\bootstrap\Html::a('内容详情',['article/content','id'=>$article->id],['class'=>'btn btn-sm btn-success'])?>
                <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$article->id],['class'=>'btn btn-sm btn-success'])?>
                <?=\yii\bootstrap\Html::a('回收站',['article/delete','id'=>$article->id],['class'=>'btn btn-sm btn-danger'])?>
                <?=\yii\bootstrap\Html::a('删除',['article/delete1','id'=>$article->id],['class'=>'btn btn-sm btn-danger'])?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页','lastPageLabel'=>'末页']);
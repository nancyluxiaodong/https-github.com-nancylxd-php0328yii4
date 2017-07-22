<?php
echo \yii\bootstrap\Html::a('添加',['article-category/add'],['class'=>'btn btn-sm btn-info'])
?>
    <table class="table table-bordered table-hover table-condensed ">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach($model as $article_category):?>
            <tr>
                <td><?=$article_category->id ?></td>
                <td><?=$article_category->name ?></td>
                <td><?=$article_category->intro ?></td>
                <td><?=$article_category->sort ?></td>
                <td><?= \backend\models\Brand::getStatusOptions()[$article_category->status]?></td>
                <td><?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$article_category->id],['class'=>'btn btn-sm btn-success'])?>
                    <?=\yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$article_category->id],['class'=>'btn btn-sm btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
<?php
echo \yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-sm btn-info'])
?>
<table class="table table-bordered table-hover table-responsive">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>图片</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $brand):?>
        <tr>
        <td><?=$brand->id ?></td>
        <td><?=$brand->name ?></td>
        <td><?=$brand->intro ?></td>
        <td><?=\yii\bootstrap\Html::img($brand->logo?$brand->logo:'/upload/default.png',['height'=>50]) ?></td>
        <td><?=$brand->sort ?></td>
        <td><?= \backend\models\Brand::getStatusOptions()[$brand->status]?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$brand->id],['class'=>'btn btn-sm btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$brand->id],['class'=>'btn btn-sm btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
<?php
echo \yii\bootstrap\Html::a('添加',['menu/add'],['class'=>'btn btn-sm btn-info'])
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>上级菜单</th>
        <th>权限(路由)</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->parent_id?></td>
        <td><?=$model->permission?></td>
        <td><?=$model->sort?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-success btn-sm'])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-danger btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
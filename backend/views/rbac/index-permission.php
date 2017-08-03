<h2>权限列表</h2>
<?php echo \yii\bootstrap\Html::a('添加',['add-permission',],['class'=>'btn btn-info'])?>
<table class="table table-bordered table-hover">
    <tr>
        <th>名称(路由)</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>
                <?php echo \yii\bootstrap\Html::a('修改',['edit-permission','name'=>$model->name],['class'=>'btn btn-info'])?>
                <?php echo \yii\bootstrap\Html::a('删除',['delete-permission','name'=>$model->name],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>

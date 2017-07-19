<a href="/goods/add" class="btn btn-sm btn-danger">添加</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>编号</th>
        <th>价格</th>
        <th>库存</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($Models as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>
            <td><?=$good->price?></td>
            <td><?=$good->total?></td>
            <td><?=$good->detail?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$good->id],['class'=>'btn btn-sm btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$good->id],['class'=>'btn btn-sm btn-success'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
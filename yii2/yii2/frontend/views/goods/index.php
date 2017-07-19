<?php
echo \yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn '])
?>
<table class="table-bordered table table-responsive">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>商品价格</th>
        <th>操作</th>
    </tr>
    <?php
//    var_dump($goods);exit;
    //遍历数组
    foreach ($goods as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=$row->price?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$row->id],['class'=>'btn btn-danger'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$row->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
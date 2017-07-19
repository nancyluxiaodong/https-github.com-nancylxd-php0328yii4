<?php
echo \yii\bootstrap\Html::a('添加',['author/add'],['class'=>'btn'])
?>
<table class="table-responsive table table-bordered ">
    <tr>
        <th>ID</th>
        <th>名字</th>
        <th>年龄</th>
        <th>性别</th>
        <th>头像</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($rows as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=$row->age?></td>
        <td><?=$row->sex==1?'男':'女'?></td>
        <td><?=\yii\bootstrap\Html::img($row->img?$row->img:'/upload/default.png',['height'=>50])?></td>
        <td><?=date('Y-m-d H:i:s',$row->intime)?></td>
        <td><?=$row->uptime?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['author/edit','id'=>$row->id],['class'=>'btn'])?>
            <?=\yii\bootstrap\Html::a('删除',['author/delete','id'=>$row->id],['class'=>'btn'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
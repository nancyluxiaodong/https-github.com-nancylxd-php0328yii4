<?php
echo \yii\bootstrap\Html::a('添加',['class/add'],['class'=>'btn ']);
?>
<table class="table-responsive table table-bordered">
    <tr>
        <th>班级id</th>
        <th>班级名</th>
        <th>操作</th>
    </tr>
<?php foreach ($rows as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['class/edit','id'=>$row->id])?>
            <?=\yii\bootstrap\Html::a('删除',['class/delete','id'=>$row->id])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
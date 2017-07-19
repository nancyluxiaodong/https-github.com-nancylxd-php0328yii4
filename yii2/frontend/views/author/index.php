<?php
echo \yii\bootstrap\Html::a('添加作者',['author/add'],['class'=>'btn btn-sm btn-success']);
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>头像</th>
        <th>生日</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $author):
        //var_dump($author);exit;
        ?>
    <tr>
        <td><?=$author->id ?></td>
        <td><?=$author->name ?></td>
        <td><?=$author->sex ?></td>
        <td><?=$author->age ?></td>
        <td><?=$author->photo ?></td>
        <td><?=$author->birthday ?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['author/edit','id'=>$author->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['author/delete','id'=>$author->id],['class'=>'btn btn-sm btn-success'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
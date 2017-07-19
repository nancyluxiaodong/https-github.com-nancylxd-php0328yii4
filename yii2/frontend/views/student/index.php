<a href="index.php?r=student/add" class="btn btn-sm btn-danger">添加</a>
<table class="table-hover table-bordered table">
    <tr>
        <th>姓名</th>
        <th>年龄</th>
        <th>班级</th>
        <th>爱好</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php
//    var_dump($Models);exit;
    foreach($Models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->age?></td>
        <td><?=$model->category_id?></td>
        <td><?=$model->hobby?></td>
        <td><?=$model->intro?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['student/edit','id'=>$model->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['student/delete','id'=>$model->id],['class'=>'btn btn-sm btn-success'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
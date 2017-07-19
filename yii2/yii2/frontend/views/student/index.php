<?=\yii\bootstrap\Html::a('添加',['student/add'],['class'=>'btn btn-sm btn-success'])?>
<table class="table-bordered table table-responsive">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>班级</th>
        <th>操作</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?=$student->id?></td>
        <td><?=$student->name?></td>
        <td><?=$student->category->name?></td>
        <td>
        <?=\yii\bootstrap\Html::a('修改',['student/edit','id'=>$student->id],['class'=>'btn btn-default'])?>
        <?=\yii\bootstrap\Html::a('删除',['student/delete','id'=>$student->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
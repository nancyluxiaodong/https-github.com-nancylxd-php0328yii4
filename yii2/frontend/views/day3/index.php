<table class="table table-bordered table-condensed">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>头像</th>
        <th>操作</th>
    </tr>
    <?php foreach($students as $student): ?>
    <tr>
        <td><?=$student->id?></td>
        <td><?=$student->name?></td>
        <td><?=$student->age?></td>
        <td><?=\yii\bootstrap\Html::img($student->img?$student->img:'/upload/default.png',['height'=>50])?></td>
        <td>修改 删除</td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);

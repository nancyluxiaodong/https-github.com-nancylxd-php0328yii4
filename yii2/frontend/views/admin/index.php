<?php
echo \yii\bootstrap\Html::a('注册新用户',['admin/add'],['class'=>'btn btn-sm btn-success']);
echo '&nbsp&nbsp';
echo \yii\bootstrap\Html::a('登录',['admin/login'],['class'=>'btn btn-sm btn-success']);
?>
<table class="table table-bordered table-hover table-responsive">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>真实姓名</th>
        <th>用户头像</th>
        <th>age</th>
        <th>sex</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $admin): ?>
            <tr>
            <td><?=$admin->id ?></td>
            <td><?=$admin->username ?></td>
            <td><?=$admin->realname ?></td>
            <td><?=\yii\bootstrap\Html::img($admin->photo?$admin->photo:'/upload/default.png',['height'=>50])?></td>
            <td><?=$admin->age ?></td>
            <td><?=\frontend\models\Admin::$sex_all[$admin->sex]?></td>
                <td><?= \yii\bootstrap\Html::a('修改',['admin/edit','id'=>$admin->id],['class'=>'btn btn-sm btn-success'])?>
                <?= \yii\bootstrap\Html::a('删除',['admin/delete','id'=>$admin->id],['class'=>'btn btn-sm btn-danger'])?></td>
        </tr>
    <?php endforeach; ?>
</table>
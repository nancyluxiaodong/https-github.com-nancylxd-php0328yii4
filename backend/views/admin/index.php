<?=
\yii\bootstrap\Html::a('添加用户',['admin/add'],['class'=>'btn btn-info'])
?>
<?=
\yii\bootstrap\Html::a('登录',['admin/login'],['class'=>'btn btn-primary'])
?>
<?=
\yii\bootstrap\Html::a('注销登录',['admin/login'],['class'=>'btn btn-primary'])
?>
<table class="table table-bordered table-hover table-condensed">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>身份验证</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>修改时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->auth_key?></td>
        <td><?=$model->email?></td>
        <td><?=$model->status?></td>
        <td><?=date('Y-m-d h:i:s',$model->created_at)?></td>
        <td><?=date('Y-m-d h:i:s',$model->updated_at)?></td>
        <td><?=$model->last_login_time?></td>
        <td><?=$model->last_login_ip?></td>
        <td>
            <?= \yii\bootstrap\Html::a('修改',['admin/edit','id'=>$model->id],['class'=>'btn btn-success btn-sm'])?>
            <?= \yii\bootstrap\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-danger btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

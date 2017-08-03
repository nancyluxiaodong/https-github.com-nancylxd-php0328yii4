<h1>Login</h1>
<?=\yii\bootstrap\Html::a('添加',['user/add'],['class'=>'btn btn-primary btn-sm'])?>
<?=\yii\bootstrap\Html::a('登录',['user/login'],['class'=>'btn btn-primary btn-sm'])?>
<?=\yii\bootstrap\Html::a('注销登录',['user/logout'],['class'=>'btn btn-danger btn-sm'])?>
<table class="table table-bordered table-responsive table-hover">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=date('Y-m-d h:i:s',$model->created_at)?></td>
            <td><?=date('Y-m-d h:i:s',$model->updated_at)?></td>
            <td><?=date('Y-m-d h:i:s',$model->last_login_time)?></td>
            <td><?=long2ip($model->last_login_ip)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改密码',['user/userupdate','id'=>$model->id],['class'=>'btn btn-info btn-sm'])?>
                <?=\yii\bootstrap\Html::a('修改',['user/edit','id'=>$model->id],['class'=>'btn btn-info btn-sm'])?>
                <?=\yii\bootstrap\Html::a('删除',['user/delete','id'=>$model->id],['class'=>'btn btn-danger btn-sm'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
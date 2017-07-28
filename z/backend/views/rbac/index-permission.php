<h1>权限列表</h1>
<table>
    <tr>
        <th>名称(路由)</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>修改|删除</td>
        </tr>
    <?php endforeach;?>
</table>
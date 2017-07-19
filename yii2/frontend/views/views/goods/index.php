<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-sm btn-success'])?>
<table class="table">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>sn</th>
        <th>价格</th>
        <th>所属分类</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->sn?></td>
        <td><?=$model->price?></td>
        <td><?=$model->category->name?></td>
        <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-sm btn-success'])?></td>
    </tr>
    <?php endforeach;?>
</table>


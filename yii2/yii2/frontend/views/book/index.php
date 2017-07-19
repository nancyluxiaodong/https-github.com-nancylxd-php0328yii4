<?php
echo \yii\bootstrap\Html::a('添加',['book/add'],['class'=>'btn'])
?>
<table class="table-responsive table table-bordered ">
    <tr>
        <th>ID</th>
        <th>书名</th>
        <th>价格</th>
        <th>作者</th>
        <th>sn</th>
        <th>上架时间</th>
        <th>更新时间</th>
        <th>是否上架</th>
        <th>图片</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->title?></td>
            <td><?=$row->price?></td>
            <td><?=$row->category->name?></td>
            <td><?=$row->sn?></td>
            <td><?=date('Y-m-d H:i:s',$row->intime)?></td>
            <td><?=$row->uptime?></td>
            <td><?=$row->status==1?'上架':'不上架'?></td>
            <td><?=\yii\bootstrap\Html::img($row->img?$row->img:'/upload/default.png',['height'=>50])?></td>
            <td><?=$row->content?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['book/edit','id'=>$row->id],['class'=>'btn'])?>
                <?=\yii\bootstrap\Html::a('删除',['book/delete','id'=>$row->id],['class'=>'btn'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);

<?php
echo \yii\bootstrap\Html::a('添加图书',['book/add'],['class'=>'btn btn-sm btn-success']);
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>图书名称</th>
        <th>作者</th>
        <th>价格</th>
        <th>货号</th>
        <th>上架时间</th>
        <th>是否上架</th>
        <th>图书简介</th>
        <th>图书封面</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $book):
        //var_dump($book);exit;
        ?>
    <tr>
        <td><?=$book->id ?></td>
        <td><?=$book->name ?></td>
        <td><?=$book->author->name ?></td>
        <!--author->name表示关联表的对应字段-->
        <td><?=$book->price ?></td>
        <td><?=$book->sn ?></td>
        <td><?=$book->sale_time ?></td>
        <td><?=$book->status ?></td>
        <td><?=$book->intro ?></td>
        <td><?=\yii\bootstrap\Html::img($book->logo?$book->logo:'/upload/default.png',['height'=>50]) ?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['book/edit','id'=>$book->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['book/delete','id'=>$book->id],['class'=>'btn btn-sm btn-success'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
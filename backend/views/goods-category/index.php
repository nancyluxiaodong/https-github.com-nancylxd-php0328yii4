<?php
/* @var $this yii\web\View */
?>
<?php echo \yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-success btn-sm'])?>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
        <tbody id="category">
        <?php foreach($model as $model1):?>
            <tr data-lft="<?=$model1->lft?>" data-rgt="<?=$model1->rgt?>" data-tree="<?=$model1->tree?>">
                <td><?=$model1->id?></td>
                <td><?=$model1->name?></td>
                <td><?=$model1->intro?></td>
                <td><?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model1->id],['class'=>'btn btn-info btn-sm'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model1->id],['class'=>'btn btn-danger btn-sm'])?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);?>
<?php
$js = <<<EOT
    $(".expand").click(function(){
        //切换图标样式
        var show = $(this).hasClass("glyphicon-chevron-up");
        $(this).toggleClass("glyphicon-chevron-down");
        $(this).toggleClass("glyphicon-chevron-up");
        //找出当前分类同一棵树下的子孙分类   同一颗树左值大于当前分类左值并且右值小于当前分类右值
        var current_tr = $(this).closest("tr");//获取当前点击图标所在tr
        var current_lft = current_tr.attr("data-lft");//当前分类左值
        var current_rgt = current_tr.attr("data-rgt");//当前分类右值
        var current_tree = current_tr.attr("data-tree");//当前分类tree值
        $("#category tr").each(function(){
            var lft = $(this).attr("data-lft");//分类的左值
            var rgt = $(this).attr("data-rgt");//分类的右值
            var tree = $(this).attr("data-tree");//分类的tree值
            if(parseInt(tree) == parseInt(current_tree) && parseInt(lft) > parseInt(current_lft) && parseInt(rgt) < parseInt(current_rgt)){
                //当前分类的子孙分类隐藏或显示
                show?$(this).fadeIn():$(this).fadeOut();
            }
        });
    });
EOT;
$this->registerJs($js);
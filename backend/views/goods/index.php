<?=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-success col-md-1']);?>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
        'method'=>'get',
        'options'=>['class'=>'form-inline'],
    ]);
echo $form->field($goods,'name')->textInput(['placeholder'=>'商品名','name'=>'keyword']);
\yii\bootstrap\ActiveForm::end();
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>logo图片</th>
        <th>商品分类</th>
        <th>品牌分类</th>
        <th>市场价格</th>
        <th>商品价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>浏览次数</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $goods):?>
    <tr>
        <td><?=$goods->id?></td>
        <td><?=$goods->name?></td>
        <td><?=$goods->sn?></td>
        <td><?=\yii\bootstrap\Html::img($goods->logo?$goods->logo:'/upload/default.png',['height'=>50]) ?></td>
        <td><?=$goods->goods_category_id?></td>
        <td><?=$goods->brand_id?></td>
        <td><?=$goods->market_price?></td>
        <td><?=$goods->shop_price?></td>
        <td><?=$goods->stock?></td>
        <td><?=$goods->is_on_sale?></td>
        <td><?=$goods->sort?></td>
        <td><?=date('Y-m-d',$goods->create_time)?></td>
        <td><?=$goods->view_times?></td>
        <td> <?=\yii\bootstrap\Html::a('查看商品详情',['goods/intro','id'=>$goods->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$goods->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$goods->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
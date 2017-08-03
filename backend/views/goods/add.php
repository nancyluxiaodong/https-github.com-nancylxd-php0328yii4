<?php
use yii\web\JsExpression;

$form= \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';
    /*->dropDownList($model->getGoodsCategorys())*/
echo $form->field($model,'brand_id')->dropDownList($model->getBrands());
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>1])->radioList(\backend\models\Goods::$sale_options);
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\Goods::$status_options);
echo $form->field($model,'sort');
echo $form->field($model,'logo')->hiddenInput();
//外部TAG
//echo \yii\bootstrap\Html::img(false,['id'=>'img','height'=>50]);copy后放到结尾去
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['goods/s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
        'width' => 120,
        'height' => 40,
        'onError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将图片地址赋值给logo字段
        $("#goods-logo").val(data.fileUrl);
        //将上传图片回显
        $("#img").attr('src',data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::img(false,['id'=>'img','height'=>50]);
echo $form->field($intromodel,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success btn-sm']);
\yii\bootstrap\ActiveForm::end();

//使用ztree，加载2个静态资源
/*<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/zTree/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/zTree/js/jquery.ztree.core.js"></script>*/
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes = \yii\helpers\Json::encode($goodscategorymodel);
$js = new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		    onClick: function(event, treeId, treeNode) {
                //console.log(treeNode.id);
                //将选中节点的id赋值给表单goods_category_id 
                $("#goods-goods_category_id").val(treeNode.id);
                //goods- 表示当前表名 goods_category_id 表示隐藏域的字段
                //console.log($("#goods-goods_category_id").val());
              
            }
	    }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};
    
    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);//展开所有节点
    //获取当前节点的父节点（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $("#goodscategory-parent_id").val(), null);
    zTreeObj.selectNode(node);//选中当前节点的父节点
JS

);
$this->registerJs($js);
?>

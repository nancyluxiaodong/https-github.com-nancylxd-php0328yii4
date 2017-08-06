<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use flyok666\uploadifive\UploadAction;
use yii\data\Pagination;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //分页 总条数 每页显示条数 当前第几页
        $query = Goods::find()->orderBy('sort desc');
        //$query->andwhere(['!=','status','0']);
        //$query->andwhere('like','name','44');
        //总条数
        $total = $query->count();
        //每页显示条数 4
        $perPage = 4;
        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);
        $model = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['model'=>$model,'pager'=>$pager]);
    }
    public function actionAdd(){
        //实例化模型
        $model = new Goods();
        $intromodel = new GoodsIntro();
        $goodscategorymodel = GoodsCategory::find()->asArray()->all();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $intromodel->load($request->post());
            if($model->validate() && $intromodel->validate()){
                $model -> create_time = time();
                //自动生成货号
                $day = date('Y-m-d');
                    $goodscount = GoodsDayCount::findOne(['day'=>$day]);
                if ($goodscount){
                    $model->sn=date('Ymd').sprintf("%04d", $goodscount->count+1);
                }else{
                    $model->sn=date('Ymd').sprintf("%04d", 1);
                }
                //数字前补0$var=sprintf("%04d", 2);
                $intromodel->good_id=$model->id;
                $intromodel->save();
                $model->save();
                if ($goodscount){
                    //var_dump(111);
                    $goodscount->count++;
                }else{
                    //var_dump(222);
                    $goodscount=new GoodsDayCount();
                    $goodscount->day=date('Y-m-d',time());
                    $goodscount->count=1;
                }
                //var_dump($goodscount->count,$goodscount->day);
                $goodscount->save(false);
                return $this->redirect(['goods/index']);
            }
        }
        $goodscategorymodel = ArrayHelper::merge([['id' => 0, 'name' => '顶级分类', 'parent_id' => 0]], $goodscategorymodel);
        return $this->render('add',['model'=>$model,'intromodel'=>$intromodel,'goodscategorymodel'=>$goodscategorymodel]);
    }
    public function actionEdit($id)
    {
        $model = Goods::findOne($id);
        $intromodel =GoodsIntro::findOne($id);
        $goodscategorymodel=GoodsCategory::find()->asArray()->all();
        $request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
            $intromodel->load($request->post());
            if ($model->validate() && $intromodel->validate()) {
                $model->save(false);
                $intromodel->save();
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('add', ['model' => $model,'intromodel'=>$intromodel,'goodscategorymodel'=>$goodscategorymodel]);

    }
    public function actionDelete($id){
        $model = Goods::findOne($id);
        if ($model){
            $model->status=0;
            $model->save();
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除失败');
        }
        return $this->redirect(['goods/index']);
    }

    //商品相册
    public function actionGallery($id){
    $goods=GoodsGallery::find()->where(['goods_id'=>$id])->all();
    return $this->render('gallery', ['goods' => $goods,'goods_id'=>$id]);
}
    public function actionDelPhoto(){
        $id=\Yii::$app->request->post('id');
        if(GoodsGallery::deleteAll(['id'=>$id])){
            return 'success';
        }
    }

    //商品详情页面
    public function actionIntro($id){
        $model = Goods::findOne($id);
        $intromodel = GoodsIntro::findOne($id);
        //跳转页面
        return $this->render('intro',['model'=>$model,'intromodel'=>$intromodel]);
    }
    //图片
    public function actions() {
        return [
            'upload' => [//百度编辑器
                'class' => 'kucha\ueditor\UEditorAction',
            ],
            's-upload' => [//uploadifive图片上传
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                'overwriteIfExist' => true,//如果文件已存在，是否覆盖
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $fileName='brand/'.date('Ymd').'/'.uniqid().'.'.$fileext;
                    return $fileName;
                },//文件的保存方式
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','gif'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //将图片上传到七牛云
                    $qiniu = new Qiniu(\Yii::$app->params['qiniu']);
                    $qiniu->uploadFile(
                        $action->getSavePath(), $action->getWebUrl()
                    );
                    $goods_id = \Yii::$app->request->post('goods_id');
                    if ( $goods_id){
                        $goodsgellery=new GoodsGallery();
                        $goodsgellery->goods_id=$goods_id;
                        $goodsgellery->path=$action->getWebUrl();
                        $goodsgellery->save();
                        $action->output['fileUrl']  =$goodsgellery->path;
                        $action->output['id']  =$goodsgellery->id;
                    }else{
                        $action->output['fileUrl']  =$action->getWebUrl();
                    }
                },
            ],
        ];
    }

}

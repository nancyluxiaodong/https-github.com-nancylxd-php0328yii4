<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
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
        $query->andwhere(['!=','status','0']);
        $query->andwhere('like','name','44');
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
            //文本编辑器
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
            //图片
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl//输出文件相对路径
                    ();
                },
            ],
        ];
    }

}

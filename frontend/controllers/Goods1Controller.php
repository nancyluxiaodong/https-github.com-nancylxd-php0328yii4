<?php
namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsIntro;
use frontend\models\GoodsCategory;
use yii\web\Controller;

class Goods1Controller extends Controller{
    public $layout=false;
    public function actionIndex(){
       $models = GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionList($id){
        $models = Goods::find()->where(['good_category_id'=>$id])->all();
        return $this->render('list',['models'=>$models]);
    }
    public function actionShow($id){
        $models=Goods::findOne(['id'=>$id]);
        $goods_intro=GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('show',['models'=>$models,'goods_intro'=>$goods_intro]);
    }
}
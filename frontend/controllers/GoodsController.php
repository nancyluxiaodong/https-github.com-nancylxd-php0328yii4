<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller
{
     public $layout=false;
     public $enableCsrfValidation = false;
     //商品主页分类页
     public function actionIndex(){
         $model=GoodsCategory::find()->where(['=','parent_id','0'])->all();
         //var_dump($model);exit;
         return $this->render('index',['model'=>$model]);
     }

     //商品列表页
    public function actionList($id){
        $model=Goods::find()->where(['=','goods_category_id',$id])->all();
        return $this->render('list',['model'=>$model]);
    }

    //商品详情页
    public function actionShow($id){
        $model=Goods::findOne(['=','id',$id]);
        $goods_intro=GoodsIntro::findOne(['=','goods_id',$id]);
        $goods_gallery=GoodsGallery::find()->where(['=','goods_id',$id])->all();
        return $this->render('show',['model'=>$model,'goods_intro'=>$goods_intro,'goods_gallery'=>$goods_gallery]);
    }

    //添加到购物车
    public function actionAddToCart($goods_id,$amount){
        if(\Yii::$app->user->isGuest) {
            //商品id 商品数量没有登录保存到cookie中；
            $cookies = \Yii::$app->request->cookies;
            //获取cookie中的购物车数据
            $cart = $cookies->get('cart');
            if ($cart == null) {
                $carts = [$goods_id => $amount];
            } else {
                $carts = unserialize($cart->value);
                if (isset($carts[$goods_id])) {
                    $carts[$goods_id] += $amount;
                } else {
                    //购物车中没有该商品
                    $carts[$goods_id] = $amount;
                }
            }

            //登录状态保存到session中；
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => serialize($cart),
                //过期时间7天这里要用时间戳
                'expire' => 7 * 24 * 3600 + time(),
            ]);
            $cookies->add($cookie);
        }else{
            //用户已登录，操作购物车数据表
        }
            //var_dump($cookies->get('cart'));
        return $this->redirect(['cart']);
    }

    //购物车页面
    public function actionCart(){
        $cookies = \Yii::$app->request->cookies;


    }
}
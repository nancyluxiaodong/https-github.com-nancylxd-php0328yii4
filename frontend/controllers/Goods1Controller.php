<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\HttpException;

class GoodsController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    //商品主页分类页
    public function actionIndex()
    {
        $model = GoodsCategory::find()->where(['=', 'parent_id', '0'])->all();
        //var_dump($model);exit;
        return $this->render('index', ['model' => $model]);
    }

    //商品列表页
    public function actionList($id)
    {
        $parent_id = [];
        $parent_id_0 = GoodsCategory::find()->select('id')->where(['=', 'parent_id', $id])->all();
        if (empty($parent_id_0)) {
            $parent_id[] = $id;
        } else {
            foreach ($parent_id_0 as $id_0) {
                $parent_id[] = $id_0->id;
                $parent_id_1 = GoodsCategory::find()->select('id')->where(['=', 'parent_id', $id_0->id])->all();
                foreach ($parent_id_1 as $id_1) {
                    $parent_id[] = $id_1->id;
                }
            }
        }
        $model = Goods::find()->where(['in', 'goods_category_id', $parent_id])->all();
        return $this->render('list', ['model' => $model]);
    }

    //商品详情页
    public function actionShow($id)
    {
        $model = Goods::findOne(['=', 'id', $id]);
        $goods_intro = GoodsIntro::findOne(['=', 'goods_id', $id]);
        $goods_gallery = GoodsGallery::find()->where(['=', 'goods_id', $id])->all();
        return $this->render('show', ['model' => $model, 'goods_intro' => $goods_intro, 'goods_gallery' => $goods_gallery]);
    }

    //添加到购物车成功页面
    public function actionAddCart($goods_id, $amount)
    {
        //未登录
        if (\Yii::$app->user->isGuest) {
            $cookies = \Yii::$app->request->cookies;
            //获取cookie中的购物车数据
            $cart = $cookies->get('cart');
            if ($cart == null) {
                $carts = [$goods_id => $amount];
            } else {
                $carts = unserialize($cart->value);//[1=>99，2=》1]
                if (isset($carts[$goods_id])) {
                    //购物车中已经有该商品，数量累加
                    $carts[$goods_id] += $amount;
                } else {
                    //购物车中没有该商品
                    $carts[$goods_id] = $amount;
                }
            }

            //将商品id和商品数量写入cookie
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => serialize($carts),
                'expire' => 7 * 24 * 3600 + time()
            ]);
            $cookies->add($cookie);
            //var_dump($cookies->get('cart'));
            //return 'ok';
        } else {
            //用户已登录，操作购物车数据表
            $member_id = \Yii::$app->user->getId();
            $model = Cart::find()->where(['=', 'member_id', $member_id])->andWhere(['=', 'goods_id', $goods_id])->one();
            if ($model) {
                $model->amount += $amount;
            } else {
                $model = new Cart();
                $model->member_id = \Yii::$app->user->getId();
                $model->goods_id = $goods_id;
                $model->amount = $amount;
            }
            $model->save();
        }
        return $this->redirect(['cart']);
    }

    //购物车页面
    public function actionCart()
    {
        $this->layout = false;
        //1 用户未登录，购物车数据从cookie取出
        if (\Yii::$app->user->isGuest) {
            $cookies = \Yii::$app->request->cookies;
            //var_dump(unserialize($cookies->getValue('cart')));
            $cart = $cookies->get('cart');
            if ($cart == null) {
                $carts = [];
            } else {
                $carts = unserialize($cart->value);
            }
            //$carts=[1=>99,2=>1]   []    =>array_keys($carts)  => [1,2]
            //获取商品数据
            $models = Goods::find()->where(['in', 'id', array_keys($carts)])->asArray()->all();
        } else {
            //2 用户已登录，购物车数据从数据表取
            $member_id = \Yii::$app->user->getId();
            $goods = Cart::find()->where(['member_id'=>$member_id])->asArray()->all();
            //var_dump($goods);exit;
            $goods_id = [];
            $carts = [];
            if ($goods) {
                foreach ($goods as $goods2) {
                    $goods_id[] = $goods2['goods_id'];
                    $carts[$goods2['goods_id']] = $goods2['amount'];
                }
            }
            $models = Goods::find()->where(['id'=>$goods_id])->asArray()->all();
        }
        return $this->render('cart', ['models' => $models, 'carts' => $carts]);
    }


    //修改购物车数据
    public function actionDeleteCart()
    {
        $goods_id = \Yii::$app->request->post('goods_id');
        $amount = \Yii::$app->request->post('amount');
        //数据验证
        if(\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            //获取cookie中的购物车数据
            $cart = $cookies->get('cart');
            if($cart==null){
                $carts = [$goods_id=>$amount];
            }else{
                $carts = unserialize($cart->value);//[1=>99，2=》1]
                if(isset($carts[$goods_id])){
                    //购物车中已经有该商品，更新数量
                    $carts[$goods_id] = $amount;
                }else{
                    //购物车中没有该商品
                    $carts[$goods_id] = $amount;
                }
            }
            //将商品id和商品数量写入cookie
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($carts),
                'expire'=>7*24*3600+time()
            ]);
            $cookies->add($cookie);
            return 'success';
        }
    }

    //订单页面
    public function actionOrder(){
        //验证用户是否登录(过滤器)最后面
        //AccessControl::className()
        //如果是游客
        if(\Yii::$app->user->isGuest){
            //跳转到登录页面
            return $this->redirect(['member/login']);
        }
        //已登录
        //开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        $order = new Order();
        $addresses = Address::findAll(['member_id'=>\Yii::$app->user->id]);
        if($order->load(\Yii::$app->request->post())){
            $order->member_id = \Yii::$app->user->id;
            $address = Address::findOne(['id'=>\Yii::$app->request->post('address_id'),'member_id'=>$order->member_id]);
            if($address==null){
                throw new HttpException('404','地址不存在');
            }
            $order->name = $address->name;
            $order->tel = $address->tel;
            $order->province = $address->province;
            $order->city = $address->city;
            $order->county = $address->county;
            $order->detail = $address->detail;
            $order->delivery_name = Order::$deliveries[$order->delivery_id]['name'];
            $order->delivery_price = Order::$deliveries[$order->delivery_id]['price'];
            $order->payment_name = Order::$payments[$order->payment_id]['name'];
            //计算总价
            $order->price = 0;
            //如果支付方式是货到付款，则状态是 待发货；如果是在线支付，则状态是 待付款
            $order->status = 1;
            $order->create_time = time();

            $order->save(false);
            //var_dump($order->getErrors());
            //var_dump($order->delivery_name);exit;
            return $this->redirect(['goods/test']);
        }
        try { //前提：数据表存储引擎必须是 innodb
            //提交事务 解决库存不足，需要回滚
            $transaction->commit();
        }catch(Exception $e){
            //回滚
            $transaction->rollBack();
        }
        $carts = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        $models=[];
        foreach($carts as $cart){
            $goods = Goods::find()->where(['id'=>$cart->goods_id])->asArray()->one();
            $goods['stock']=$cart->amount;
            $models[]=$goods;
        }
        return $this->render('order',['models'=>$models,'addresses'=>$addresses]);
    }

    //过滤器
    /* public function behaviors()
     {
         return [
             'ACF'=>[
                 'class'=>AccessControl::className(),
                 //哪些操作需要使用该过滤控制器
                 'only'=>['order']]];
     }*/
}
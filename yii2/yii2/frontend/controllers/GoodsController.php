<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/14
 * Time: 17:59
 */
namespace frontend\controllers;
 use frontend\models\Goods;
 use yii\web\Controller;
 use yii\web\Request;

 class GoodsController extends Controller{
     //首页
     public function actionIndex(){
         //获取数据
//        $goods=new Goods();
         $goods=Goods::find()->All();
        //跳转到视图并分配数据
        return $this->render('index',['goods'=>$goods]);
     }
     //添加
     public function actionAdd(){
         //实例化数据库
         $goods=new Goods();
         $reques=new Request();
         //判断是否是post提交
         if ($reques->isPost){
             //把接收的数据报错到数据库
            $goods->load($reques->post());
            //验证数据
            if ($goods->validate()){
                //保存数据
                $goods->save();
                //跳转
                return $this->redirect(['goods/index']);
            }
         }
        //跳转并分配
         return $this->render('add',['goods'=>$goods]);
     }
     //修改
     public function actionEdit($id){
         //找到该ID数据
         $goods=Goods::findOne(['id'=>$id]);
         //判断请求方式
         $request=new Request();
         if ($request->isPost){
             //接收数据
             $goods->load($request->post());
            //验证数据
             if ($goods->validate()){
                //成功后保存
                 $goods->save();
                 //然后跳转
                 return $this->redirect(['goods/index']);
            }
         }
        //把数据分配到add页面
        return $this->render('add',['goods'=>$goods]);
     }
     //删除
     public function actionDelete($id){
         //找到该ID数据
         $goods=Goods::findOne(['id'=>$id]);
         //删除该数据
         $goods->delete();
         //跳转
         return $this->redirect(['goods/index']);
     }
 }
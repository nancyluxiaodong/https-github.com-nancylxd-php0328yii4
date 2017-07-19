<?php
namespace frontend\controllers;

use frontend\models\Goods;
use yii\web\Controller;
use yii\web\Request;

class GoodsController extends Controller
{
    //显示列表
    public function actionIndex()
    {
        //获取所有商品数据 数组
        $Models = Goods::find()->all();
        //调用视图,分配数据
        return $this->render('index', ['Models' => $Models]);
    }

    //添加商品
    public function actionAdd()
    {
        //1.展示添加表单
        //实例化表单模型
        $model = new Goods();
        //接受并保存到数据表
        $request = new Request();
        if ($request->isPost) {
            //加载表单数据
            $model->load($request->Post());
            //验证数据
            if ($model->validate()) {
                //验证通过保存到数据库
                $model->create_time=time();
                //var_dump($model);exit;
                $model->save();
                //跳转页面
                return $this->redirect(['goods/index']);
            } else {
                //打印错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    //修改商品信息
    public function actionEdit($id)
    {
        //根据id查询数据
        $model = Goods::findOne(['id' => $id]);
        //数据回显
        $request = new Request();
        //接受表单数据
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
                return $this->redirect('/goods/index');
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }
        //更新数据库
        return $this->render('add', ['model' => $model]);
    }
    //删除商品信息
    public function actionDelete($id){
        //根据id查询数据
        $model = Goods::findOne(['id'=>$id]);
        //删除该条数据
        $model->delete();
        //跳转页面
        return $this->redirect(['/goods/index']);
    }
}
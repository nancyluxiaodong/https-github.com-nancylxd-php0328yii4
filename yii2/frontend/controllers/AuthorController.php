<?php
namespace frontend\controllers;

use frontend\models\Author;
use yii\web\Controller;
use yii\web\Request;

class AuthorController extends Controller{
    public function actionIndex(){
        //获取数据
        $models = Author::find()->all();
        //调用视图
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        //实例化表单模型
        $models = new Author();
//      接收并保存到数据表
        $request = new Request();
        if($request->isPost){
            //添加表单数据
            $models->load($request->Post());
            //验证数据
            if($models->Validate()){
                //通过验证保存到数据库
                $models -> save();
                //跳转页面
                return $this->redirect(['/author/index']);
            }else{
                var_dump($models->getErrors());exit;
            }
        }
        return $this->render('add',['models'=>$models]);
    }
    //修改数据
    public function actionEdit($id){
        //获取id数据
        $models = Author::findOne(['id'=>$id]);
        //数据回显
        $request = new Request();
        //接收表单数据
        if($request->isPost){
            //接收数据
            $models->load($request->Post());
            //验证数据
            if($models->validate()){
                //保存数据
                $models->save();
                //跳转页面
                return $this->redirect('/author/index');
            }else{
                //错误提示
                var_dump($models->getErrors());
            }
        }
        //get显示页面
        return $this->render('add',['models'=>$models]);
    }
    public function actionDelete($id){
        //获取id数据
        $models = Author::findOne(['id'=>$id]);
        //删除数据
        $models->delete();
        //跳转页面
        return $this->redirect('/author/index');
    }
}

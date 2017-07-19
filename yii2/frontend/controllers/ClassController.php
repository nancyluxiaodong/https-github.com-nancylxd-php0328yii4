<?php
namespace frontend\controllers;

use frontend\models\StudentClass;
use yii\web\Controller;
use yii\web\Request;

class ClassController extends Controller{
    //首页
    public function actionIndex(){
        //查出数据
        $class=StudentClass::find()->all();
        //跳转
        return $this->render('index',['rows'=>$class]);
    }
    //添加
    public function actionAdd()
    {
        //实例化数据库
        $studentclass=new StudentClass();
        $request=new Request();
        //判断提交方式
        if ($request->isPost){
            //接收数据
            $studentclass->load($request->post());
            //判断数据合法性
            if ($studentclass->validate()){
//                echo 111;exit;
                //保存
                $studentclass->save();
              //跳转
                return $this->redirect(['class/index']);
            }
        }
        //分配数据并跳转
        return $this->render('add',['rows'=>$studentclass]);
    }
//删除
    public function actionDelete($id){
        $studentclass=StudentClass::findOne(['id'=>$id]);
        $studentclass->delete();

        return $this->redirect(['class/index']);
    }
//修改
    public function actionEdit($id){
        //找到该ID数据
        $studentclass=StudentClass::findOne($id);
        $request=new Request();
        //判断请求方式
        if ($request->isPost){
            //接收数据
            $studentclass->load($request->post());
            //验证数据
            if ($studentclass->validate()){
                //保存数据
                $studentclass->save();
                //跳转
                return $this->redirect(['class/index']);
            }
        }
        //分配数据并跳转
        return $this->render('add',['rows'=>$studentclass]);
    }
}
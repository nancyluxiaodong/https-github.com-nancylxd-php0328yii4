<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/13
 * Time: 18:31
 */
namespace frontend\controllers;
use frontend\models\Student;
use frontend\models\StudentClass;
use yii\web\Controller;
use yii\web\Request;

class StudentController extends Controller{
    //首页
    public function actionIndex(){
        //实例化model 得到数据
//        $student=new Student();
        $student=Student::find()->all();
        //分配数据到index页面
        return $this->render('index',['students'=>$student]);
    }
    //添加
    public function actionAdd(){
        //实例化数据库
        $student=new Student();
        $request=new Request();
        //判断请求方式
        if ($request->isPost){
            //接收数据
//            var_dump($request->post());exit;
            $student->load($request->post());
            //验证数据合法性
            if ($student->validate()){
                $student->save();//保存
                //跳转
                return $this->redirect(['student/index']);
            }

        }
//        var_dump(StudentClass::find()->All());exit;
        //获取班级表数据
        $rows=StudentClass::find()->All();
        //分配数据并跳转
        return $this->render('add',['model'=>$student,'rows'=>$rows]);

    }
    //修改
    public function actionEdit($id){
//        echo $id;
        //获取数据
        $student=Student::findOne(['id'=>$id]);
        $request=new Request();
        //判断提交方式
        if ($request->isPost){
            //接收数据
            $student->load($request->post());
            if ($student->validate()){
                //保存
                $student->save();
                //跳转
                return $this->redirect(['student/index']);
            }
        }
        //获取班级表所以数据
        $rows=StudentClass::find()->All();
        //分配数据并跳转
        return $this->render('add',['model'=>$student,'rows'=>$rows]);
    }

    //删除
    public function actionDelete($id){
        //查询数据
        $student=Student::findOne(['id'=>$id]);
        //删除数据
        $student->delete();
        //跳转
        return $this->redirect(['student/index']);
    }
//    public function actionAaa(){
//        $rows= Student::find()->All();
//        echo '<pre/>';
////       var_dump($rows->name);exit;
//        foreach ($rows as $row){
//            var_dump($row->name);
//
//        }
//    }
}
<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/15
 * Time: 18:13
 */
namespace frontend\controllers;
use frontend\models\Author;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class AuthorController extends Controller{
    //首页
    public function actionIndex(){
        //查询数据
        $rows=Author::find()->All();
//        var_dump($rows);
        //z/分配数据
        return $this->render('index',['rows'=>$rows]);
    }
    //添加
    public function actionAdd(){
        //实例化数据库
        $model=new Author();
        $request=new Request();
        if ($request->isPost){
            //接收数据
//            var_dump($request->post());exit;
            $model->load($request->post());
            //接收图片
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->imgFile);
            //验证数据
            if ($model->validate()){
                //判断是否上传图片
                if ($model->imgFile){
                    //如果上传,创建当天时间文件夹
                    $dir=\Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if (!is_dir($dir)){
                        //创建文件
                        mkdir($dir,0777,true);
                    }
                    //拼凑完整路径
                    $fileName='/upload/'.date('Ymd').'/'.uniqid().'.'.$model->imgFile->extension;
//                    var_dump($fileName);exit;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->img=$fileName;
                }
                //保存
                $date=time();
                $model->intime=$date;
                $model->save(false);
                return $this->redirect(['author/index']);
            }
        }
        //分配跳转
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id){
        //查询出数据
        $model=Author::findOne(['id'=>$id]);
        //如果上传就删除原图片
//                    var_dump($model->img);exit;

        $request=new Request();
        if ($request->isPost){
            //接收数据
            $model->load($request->post());
            //接收图片
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->imgFile);
            //验证数据
            if ($model->validate()){
                //判断是否上传图片
                if ($model->imgFile){
                    if (isset($model->img)){
                        //坑.坑.坑
                        //删除图片
                        var_dump($model->img);
                        unlink('.'.$model->img);
                    }
                    //如果上传,创建当天时间文件夹
                    $dir=\Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if (!is_dir($dir)){
                        //创建文件
                        mkdir($dir,0777,true);
                    }
                    //拼凑完整路径
                    $fileName='/upload/'.date('Ymd').'/'.uniqid().'.'.$model->imgFile->extension;
//                    var_dump($fileName);exit;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->img=$fileName;
                }
                $model->save(false);
                return $this->redirect(['author/index']);
            }
        }
        //分配跳转
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDelete($id){
        $model=Author::findOne(['id'=>$id]);
//       echo "<img src='".$model->img."'/>";exit;
       if ($model->img){
           //坑.坑.坑
           //删除图片
       unlink(\Yii::getAlias('@webroot').$model->img);
       }
       //删除该数据
       $model->delete();
       //跳转
        return $this->redirect(['author/index']);
    }
}
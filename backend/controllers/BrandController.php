<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //分页 总条数 每页显示条数 当前第几页
        $query = Brand::find();
        //总条数
        $total = $query->count();
        //var_dump($total);exit;
        //每页显示条数 4
        $perPage = 4;
        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);
        $model = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['model'=>$model,'pager'=>$pager]);
        //$model = Brand::find()->all();
        //return $this->render('index',['model'=>$model]);
    }
    public function actionAdd(){
        //实例化表单模型
        $model = new Brand();
        //接收并保存
        $request = new Request();

        if($request->isPost){
            //
            $model->load($request->post());
            //var_dump($model);exit;
            $model->logoFile = UploadedFile::getInstance($model,'logoFile');
            //var_dump($model);exit;
            if($model->validate()){

               //var_dump($model);exit;
                if($model->logoFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d,0777,true);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;
                    //var_dump($model);exit;
                    $model->save();
                    //跳转页面
                    return $this->redirect(['brand/index']);
                }else{
                    var_dump($model->getErrors());
                }
            }
        }
        return $this->render('add',['model'=>$model]);
    }


    public function actionEdit($id){
        //实例化表单模型
        $model = Brand::findOne(['id'=>$id]);
        //接收并保存
        $request = new Request();

        if($request->isPost){
            //
            $model->load($request->post());
            //var_dump($model);exit;
            $model->logoFile = UploadedFile::getInstance($model,'logoFile');
            //var_dump($model);exit;
            if($model->validate()){

                //var_dump($model);exit;
                if($model->logoFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d,0777,true);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;
                    //var_dump($model);exit;
                    $model->save();
                    //跳转页面
                    return $this->redirect(['brand/index']);
                }else{
                    var_dump($model->getErrors());
                }
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['brand/index']);
    }
}

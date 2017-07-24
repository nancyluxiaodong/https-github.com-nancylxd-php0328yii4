<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //分页 总条数 每页显示条数 当前第几页
        $query = Brand::find();
        //总条数12
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
            $model->load($request->post());
            //$model->logo= UploadedFile::getInstance($model,'logo');
            if($model->validate()){
               /* if($model->logoFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d,0777,true);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;*/
                    //var_dump($model);exit;
                    $model->save();
                    //跳转页面
                    return $this->redirect(['brand/index']);
                }else{
                    var_dump($model->getErrors());
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
            //$model->logoFile = UploadedFile::getInstance($model,'logoFile');
            //var_dump($model);exit;
            if($model->validate()){

                //var_dump($model);exit;
                /*if($model->logoFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d,0777,true);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;*/
                    //var_dump($model);exit;
                    $model->save();
                    //跳转页面
                    return $this->redirect(['brand/index']);
                }else{
                    var_dump($model->getErrors());
                }
            }

        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['brand/index']);
    }

//图片
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
               /* 'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl// 输出文件相对路径
();
                    /*$action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"*/
                },
            ],
        ];
    }



    //七牛云文件上传测试
    public function actionQiniu(){
        $config = [
            'accessKey'=>'4cIZ3S6SrNKSSzz4nnvT62etcz6mlvW_IPI6V6Y2',
            'secretKey'=>'UaC5Vlj-7jlQmpMckiipRxD_scKbcgSNXfN8CrfJ',
            'domain'=>'http://ote8xsree.bkt.clouddn.com/',
            'bucket'=>'yii3',
            'area'=>Qiniu::AREA_HUADONG
        ];
        $qiniu = new Qiniu($config);
        $key = 'upload/79/fd/79fdf3779608d47f36981b6dbe2460f26a60cf57.jpg';
        $qiniu->uploadFile(\Yii::getAlias('@webroot').'/upload/79/fd/79fdf3779608d47f36981b6dbe2460f26a60cf57.jpg');
        $url = $qiniu->getLink($key);
        var_dump($url);
    }

}

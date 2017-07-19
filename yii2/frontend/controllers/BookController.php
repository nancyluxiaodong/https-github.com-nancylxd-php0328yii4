<?php
namespace frontend\controllers;

use frontend\models\Book;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;

class BookController extends Controller
{
    public function actionIndex(){
        //分页 总条数 每页显示条数 当前第几页
        $query = Book::find();
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
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    public function actionAdd()
    {
        //1.展示添加表单
        //实例化表单模型
        $model = new Book();
        //接受并保存到数据表
        $request = new Request();
        if ($request->isPost) {
            //加载表单数据
            $model->load($request->post());
            //实例化文件上传对象
            $model->logoFile = UploadedFile::getInstance($model,'logoFile');
            //验证数据
            if ($model->validate()) {
                //验证通过保存到数据库
                    /*$fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;*/
                if($model->logoFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo = $fileName;
                }
                //var_dump($model);exit;
                $model->save(false);
                //跳转页面
                return $this->redirect(['book/index']);
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
        $model = Book::findOne(['id' => $id]);
        //数据回显
        $request = new Request();
        //接受表单数据
        //实例化文件上传对象
        $model->logoFile=UploadedFile::getInstance($model,'logoFile');
        if ($request->isPost) {
            //
            $model->load($request->post());
            //验证数据
            if ($model->validate()) {
                $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->logoFile->extension;
                $model->logoFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                $model->logo = $fileName;
                //调用视图，跳转页面
                return $this->redirect('/book/index');
            } else {
                //显示错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        //跳转页面
        return $this->render('add', ['model' => $model]);
    }
    //删除商品信息
    public function actionDelete($id){
        //根据id查询数据
        $model = Book::findOne(['id'=>$id]);
        //删除该条数据
        $model->delete();
        //跳转页面
        return $this->redirect(['/book/index']);
    }
    //定义验证码操作
    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'minLength'=>3,
                'maxLength'=>3,
            ]
        ];
    }
}
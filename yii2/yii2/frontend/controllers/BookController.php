<?php
/**
 * Created by PhpStorm.
 * User: 刘杰
 * Date: 2017/7/15
 * Time: 21:27
 */
namespace frontend\controllers;
use frontend\models\Author;
use frontend\models\Book;
use yii\web\Controller;
use yii\captcha\CaptchaAction;
use yii\web\Request;
use yii\web\UploadedFile;
use yii\data\Pagination;

class BookController extends Controller{
    public $imgFile;//保存文件上传对象
    public $code;//验证码
    //首页
    public function actionIndex(){
        //分页 总条数 每页显示条数 当前第几页
        $query = Book::find();
        //总条数
        $total = $query->count();
        //var_dump($total);exit;
        //每页显示条数 3
        $perPage = 1;

        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);

        //LIMIT 0,3   ==> limit(3)->offset(0)
        $model = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['rows'=>$model,'pager'=>$pager]);
    }
    //添加
    public function actionAdd(){
        $model=new Book();
       $request=new Request();
       if ($request->isPost){
//           var_dump($request->post());exit;
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
               $date=time();
               $model->intime=$date;
               $model->save(false);
//               var_dump($model->getErrors());exit;
               return $this->redirect(['book/index']);
           }
//           echo 11;exit;
       }
//       echo 333;exit;
        $row=Author::find()->all();
//       var_dump($row);exit;
        return $this->render('add',['model'=>$model,'rows'=>$row]);
    }
    //定义验证码操作
    public function actions(){
        return [
            'captcha'=>[
//                'class'=>'yii\captcha\CaptchaAction',
                'class'=>CaptchaAction::className(),
                //
                'minLength'=>3,
                'maxLength'=>3,
            ]
        ];
    }
    //修改
    public function actionEdit($id){
        //查询出数据
        $model=Book::findOne(['id'=>$id]);
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
//                        var_dump($model->img);
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
                return $this->redirect(['book/index']);
            }
        }
        $row=Author::find()->all();
        //分配跳转
        return $this->render('add',['model'=>$model,'rows'=>$row]);
    }
    //删除
    public function actionDelete($id){
        $model=Book::findOne(['id'=>$id]);
//       echo "<img src='".$model->img."'/>";exit;
        if ($model->img){
            //坑.坑.坑
            //删除图片
            unlink('.'.$model->img);
        }
        //删除该数据
        $model->delete();
        //跳转
        return $this->redirect(['book/index']);
    }


}
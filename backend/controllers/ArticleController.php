<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use backend\models\ArticleSearchForm;
use yii\data\Pagination;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $model = new ArticleSearchForm();
        //分页 总条数 每页显示条数 当前第几页
        /*$request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
        }*/
        $model ->load(\Yii::$app->request->get());
        $query = Article::find()->where(['!=','status','-1'])->orderBy('sort desc');
        //搜索功能
        if($model->name){
            $query->andWhere(['like','name',$model->name]);
        }
        if($model->intro){
            $query->andWhere(['like','name',$model->intro]);
        }
        if($model->sort){
            $query->andWhere(['like','name',$model->sort]);
        }
        //总条数
        $total = $query->count();
        //每页显示条数 4
        $perPage = 4;
        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);
        $articles = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['model'=>$model,'articles'=>$articles,'pager'=>$pager]);
    }
    //添加表单
    public function actionAdd(){
        //实例化模型
        $model = new Article();
        $detailmodel = new ArticleDetail();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $detailmodel->load($request->post());
            if($model->validate() && $detailmodel->validate()){
                $model->create_time=time();
                $model->save();
                $detailmodel->article_id=$model->id;
                $detailmodel->save();
                //跳转页面
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'detailmodel'=>$detailmodel]);
    }
    //修改表单
    public function actionEdit($id){
        //实例化模型
        $model = Article::findOne($id);
        $detailmodel = ArticleDetail::findOne($id);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $detailmodel->load($request->post());
            if($model->validate() && $detailmodel->validate()){
                $model->create_time=time();
                $model->save();
                $detailmodel->article_id=$model->id;
                $detailmodel->save();
                //跳转页面
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'detailmodel'=>$detailmodel]);
    }
    //逻辑删除文章
    public function actionDelete($id){
        $model = Article::findOne($id);
        $model -> status = -1;
        $model ->save();
        //跳转
        return $this->redirect(['article/index']);
    }
    //彻底删除文章
    public function actionDelete1($id){
        $model = Article::findOne($id);
        $detailmodel = ArticleDetail::findOne($id);
        $model ->delete();
        $detailmodel ->delete();
        //跳转
        return $this->redirect(['article/index']);
    }
    //内容详情页面
    public function actionContent($id){
        $model = Article::findOne($id);
        $detailmodel = ArticleDetail::findOne($id/*这里为什么用$id就可以取出内容*/);
        //跳转页面
        return $this->render('content',['model'=>$model,'detailmodel'=>$detailmodel]);
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
}

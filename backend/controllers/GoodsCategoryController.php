<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {//分页 总条数 每页显示条数 当前第几页
        $query = GoodsCategory::find();
        //总条数
        $total = $query->count();
        //每页显示条数 4
        $perPage = 4;
        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);
        $model = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['model'=>$model,'pager'=>$pager]);
    }

    /*public function actionAdd(){
        $model = new GoodsCategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            if($model->partend_id){
            //添加非一级分类
            $parend = GoodsCategory::findOne(['id'=>$model->partend_id]);
                //添加到上一级分类下面
                $model ->prependTo($parend);
            }else{
                $model->makeRoot();
            }
            return $this->redirect(['goods-category/index']);
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }*/
    //添加商品分类
    public function actionAdd()
    {
        $model = new GoodsCategory();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //判断是否是添加一级分类（parent_id是否为0）
            if ($model->parent_id) {
                //添加非一级分类
                $parent = GoodsCategory::findOne(['id' => $model->parent_id]);//获取上一级分类
                $model->prependTo($parent);//添加到上一级分类下面
            } else {
                //添加一级分类
                $model->makeRoot();
            }
            return $this->redirect(['goods-category/index']);
        }
        $categories = ArrayHelper::merge([['id' => 0, 'name' => '顶级分类', 'parent_id' => 0]], GoodsCategory::find()->asArray()->all());


        return $this->render('add', ['model' => $model, 'categories' => $categories]);
    }

    //修改
    public function actionEdit($id)
    {
        $model = GoodsCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('分类不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断是否是添加一级分类（parent_id是否为0）
            if($model->parent_id){
                //添加非一级分类
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                //获取上一级分类
                $model->prependTo($parent);
            }else{
                //添加一级分类
                $model->makeRoot();
            }
            return $this->redirect(['goods-category/index']);
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());


        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }
    public function actionDelete($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        $goods = GoodsCategory::findOne(['parent_id'=>$id]);
        //var_dump($model);exit;
          if($goods){
              \yii::$app->session->setFlash('danger','删除失败,该分类有下级分类');
              return $this->redirect(['goods-category/index']);
          }else{

              $model->deleteWithChildren();//这样可以删除顶级分类
              return $this->redirect(['goods-category/index']);
          }
        }
    //测试嵌套集合插件用法
    public function actionTest(){
        //创建一个根节点
        /*$category = new GoodsCategory();
        $category ->name = '家用电器';
        $category->makeRoot();*/
        //创建一个子节点
        /*$category2 = new GoodsCategory();
        $category2 ->name = '大家电';
        $category = GoodsCategory::findOne(['id'=>1]);
        $category2->parend_id = $category->id;
        $category2->prependTo($category);*/
        //创建一个分节点
        /*$category2 = new GoodsCategory();
        $category2 ->name = '小家电';
        $category = GoodsCategory::findOne(['id'=>1]);
        $category2 ->parend_id=$category->id;
        $category2->prependTo($category);*/
        //删除一个节点
        //$category = GoodsCategory::findOne(['id'=>4])->delete();
        echo '操作完成';
    }
}

<?php

namespace backend\controllers;

use backend\models\Menu;
use yii\data\Pagination;
use yii\filters\AccessControl;

class MenuController extends \yii\web\Controller
{
    //菜单添加
    public function actionAdd(){
        $model = new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            //跳转
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //菜单显示
    public function actionIndex()
    {   //上级菜单没有
       // $models = Menu::find()->all();
        //return $this->render('index',['models'=>$models]);
        //分页 总条数 每页显示条数 当前第几页
        $query = Menu::find();//->where(['parent_id'=>0]);
        //总条数12
        $total = $query->count();
        //var_dump($total);exit;
        //每页显示条数12
        $perPage = 8;
        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //菜单修改
    public function actionEdit($id){
        $model = Menu::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id && !empty($model->children)){
                $model->addError('parent_id','只能为顶级菜单');
            }else{
                $model->save();
                return $this->redirect(['index']);
            }
        }
        return $this->render('add',['model'=>$model]);
}

    //菜单修改
    public function actionDelete($id){
        $model = Menu::findOne(['id'=>$id]);
        $menu =Menu::findOne(['parent_id'=>$id]);
        if($menu){
            \Yii::$app->session->setFlash('danger','删除失败,存在下级分类');
            return $this->redirect(['menu/index']);
        }else{
            $model->delete();
            return $this->redirect(['menu/index']);
        }
    }

}

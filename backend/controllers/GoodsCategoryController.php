<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $cates=GoodsCategory::find()->orderBy('tree,lft')->all();

        return $this->render('index1',['cates'=>$cates]);
    }

    /**
     * 添加商品分类
     */
    public function actionAdd()
    {
        $model=new GoodsCategory();
        //判断是不是Post提交
        $request=\Yii::$app->request;

        if ($request->isPost){

            //数据绑定
            $model->load($request->post());

            if ($model->validate()){

                //判断父亲Id是不是0 如果是0创建根目录

                if ($model->parent_id==0){
                    //创建根目录
                   /* $cate=new GoodsCategory();
                    $cate->name="家电";
                    $cate->parent_id=0;
                    $cate->makeRoot();*/
                   $model->makeRoot();
                }else{

                    //创建子分类

                    //1.把父节点找到
                    $cateParent=GoodsCategory::findOne(['id'=>$model->parent_id]);

                    //2. 把当前节点对象添加到父类对象中

                    $model->prependTo($cateParent);

                }
                \Yii::$app->session->setFlash("success",'添加目录成功');

                //刷新
               return $this->refresh();


            }

        }
        //得到所有的分类
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);


       // var_dump($cates);exit;

        //显示视图
        return $this->render("add",['model'=>$model,'cates'=>$cates]);

   }

    /**
     * 添加商品分类
     */
    public function actionEdit($id)
    {
        $model=GoodsCategory::findOne($id);
        //判断是不是Post提交
        $request=\Yii::$app->request;

        if ($request->isPost){

            //数据绑定
            $model->load($request->post());

            if ($model->validate()){

                try{
                    //判断父亲Id是不是0 如果是0创建根目录

                    if ($model->parent_id==0){
                        //创建根目录
                        /* $cate=new GoodsCategory();
                         $cate->name="家电";
                         $cate->parent_id=0;
                         $cate->makeRoot();*/
                        // $model->makeRoot();
                        $model->save();
                    }else{

                        //创建子分类

                        //1.把父节点找到
                        $cateParent=GoodsCategory::findOne(['id'=>$model->parent_id]);

                        //2. 把当前节点对象添加到父类对象中

                        $model->prependTo($cateParent);

                    }
                }catch (\yii\db\Exception $e){
                  //  var_dump($e->getMessage());exit;
                    \Yii::$app->session->setFlash("danger",$e->getMessage());
                    return $this->refresh();

                }

                \Yii::$app->session->setFlash("success",'添加目录成功');

            }

        }
        //得到所有的分类
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);


        // var_dump($cates);exit;

        //显示视图
        return $this->render("add",['model'=>$model,'cates'=>$cates]);

    }

    public function actionTest()
    {
        $cate=new GoodsCategory();
        $cate->name="家电";
        $cate->parent_id=0;
        $cate->makeRoot();

        var_dump($cate->getErrors());

    }
    public function actionAddChild()
    {
      //创建儿子分类
        $cate=new GoodsCategory();
        $cate->name="冰箱";
        $cate->parent_id=1;
     //找出家电分类对象
        //把儿子分类加入家电分类
        $cateParent=GoodsCategory::findOne(['id'=>$cate->parent_id]);
        $cate->prependTo($cateParent);


    }

    /**
     * 删除
     */
    public function actionDel($id)
    {
        //找到删除的分类

        $cate=GoodsCategory::findOne($id);

        //删除当前节点和它的子节点
        $cate->deleteWithChildren();

        $this->redirect(['index']);
    }

    public function actionZtree(){


        return $this->render("ztree");
    }

    public function actionAdd1()
    {
        $model=new GoodsCategory();
        //判断是不是Post提交
        $request=\Yii::$app->request;

        if ($request->isPost){

            //数据绑定
            $model->load($request->post());

            if ($model->validate()){

                //判断父亲Id是不是0 如果是0创建根目录

                if ($model->parent_id==0){
                    //创建根目录
                    /* $cate=new GoodsCategory();
                     $cate->name="家电";
                     $cate->parent_id=0;
                     $cate->makeRoot();*/
                    $model->makeRoot();
                }else{

                    //创建子分类

                    //1.把父节点找到
                    $cateParent=GoodsCategory::findOne(['id'=>$model->parent_id]);

                    //2. 把当前节点对象添加到父类对象中

                    $model->prependTo($cateParent);

                }
                \Yii::$app->session->setFlash("success",'添加目录成功');

                //刷新
                return $this->refresh();


            }

        }
        //得到所有的分类
        $cates=GoodsCategory::find()->orderBy('tree,lft')->all();
       // $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates= ArrayHelper::map($cates,'id','nameText');
        $cates=ArrayHelper::merge(['0'=>'顶级分类'],$cates);
       // $cates=Json::encode($cates);
        // var_dump($cates);exit;

        //显示视图
        return $this->render("add1",['model'=>$model,'cates'=>$cates]);
    }

}

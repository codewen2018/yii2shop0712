<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    /**
     * 文章列表
     * @return string
     */
    public function actionIndex()
    {
        $models = Article::find()->all();

        return $this->render('index', ['models' => $models]);
    }

    public function actionAdd()
    {
        //创建文章对象
        $article = new Article();
        //创建文章内容模型
        $articleDetail = new ArticleDetail();
        $request = \Yii::$app->request;
        /*  if ($request->isPost){
            echo "<pre>";
              var_dump($request->post());exit;


          }*/
        //绑定数据
        $article->load($request->post());
        $articleDetail->load($request->post());
        //验证
        if ($article->validate() && $articleDetail->validate()) {
            //直接保存 文章
            $article->save();
            //文章内容的Id就是刚刚新增文章的那个Id
            $articleDetail->article_id = $article->id;
            //保存文章内容
            $articleDetail->save();
            //提示
            \Yii::$app->session->setFlash("success", "添加成功");

            return $this->redirect(["index"]);

        }else{
            var_dump($article->getErrors(),$articleDetail->getErrors());exit;

        }
        //得到所有分类
        $cates = ArticleCategory::find()->all();
        //得到需要数组
        $catesArr = ArrayHelper::map($cates, 'id', "name");// 1=>name
        // var_dump($catesArr);exit;
        //显示视图
        return $this->render('add',
            ['article' => $article, 'articleDetail' => $articleDetail, 'catesArr' => $catesArr]);


    }

}

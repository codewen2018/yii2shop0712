<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    /**
     * 分类列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据
        $models = ArticleCategory::find()->all();
        return $this->render('index', ['models' => $models]);
    }

    /**
     * 文章分类添加
     * @return string
     */
    public function actionAdd()
    {
        $model=new ArticleCategory();
        $request=\Yii::$app->request;
        //绑定和验证
        if ($model->load($request->post()) && $model->validate()){

            $model->save();

            return $this->redirect(['index']);


        }

        return $this->render('add', ['model' => $model]);
    }

}

<?php

namespace frontend\controllers;

class IndexController extends \yii\web\Controller
{
    public $layout="index";
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        return $this->render('list');

    }

}

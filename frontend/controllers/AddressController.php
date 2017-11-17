<?php

namespace frontend\controllers;

class AddressController extends \yii\web\Controller
{
    public $layout="public";
    public function actionIndex()
    {
        return $this->render('index');
    }

}

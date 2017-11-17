<?php

namespace frontend\controllers;

class AddressController extends \yii\web\Controller
{
    public $layout="member";
    public function actionIndex()
    {
        return $this->render('index');
    }

}

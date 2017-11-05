<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/3
 * Time: 21:20
 * Company: 源码时代重庆校区
 */

namespace backend\controllers;


use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex(){


        return $this->render('index');


    }


}
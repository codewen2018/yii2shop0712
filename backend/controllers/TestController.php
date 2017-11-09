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

    public function actionTest()
    {

        $str1="wo@iphp@3432";
        $str2=rand(100000,999999);
        echo md5($str1.'123456'.time());
        echo "<br>";
        $str2=rand(100000,999999);
        echo md5($str1.'123456'.$str2);



    }


}
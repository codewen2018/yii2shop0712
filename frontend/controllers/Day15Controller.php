<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/23
 * Time: 11:39
 * Company: 源码时代重庆校区
 */

namespace frontend\controllers;


use yii\redis\Connection;

class Day15Controller extends BaseController
{

    public function actionRedis(){

        \Yii::$app->session->set("name","safw");

       // \Yii::$app->redis->set("name","lei");

       //echo (new Connection())->get("name");

        var_dump(\Yii::$app->session->get("name"));


    }


}
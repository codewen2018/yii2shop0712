<?php

namespace frontend\controllers;

use frontend\models\Member;
use Mrgoon\AliSms\AliSms;

class MemberController extends \yii\web\Controller
{

    public $layout="login";
    public $enableCsrfValidation=false;
    public function actionReg()
    {
        $model=new Member();
        $request=\Yii::$app->request;
        if ($request->isPost){

            $model->load($request->post());
            if ($model->validate()){

               exit("ok");
            }else{
                var_dump($model->getErrors());exit;

            }



        }

        return $this->render('reg',compact('model'));
    }

    public function actionSms(){

       // $this->enableCsrfValidation=false;
        //接收参数
        $mobile=\Yii::$app->request->post('mobile');
        //1.生成验证码

        //2.发送给手机
        $code=rand(1000,9999);

        $config = [
            'access_key' => 'LTAIu8FJuAqDxkT1',
            'access_secret' => 'cwsFM0UKaQyikgYhqtP3c0QqVfzbQH',
            'sign_name' => '老文',
        ];


        $sms = new AliSms();
       // $response = $sms->sendSms($mobile, 'SMS_110560035', ['code'=> $code], $config);
        //3.存储验证码  tel=>8888   tel_15866664444=>6666
        \Yii::$app->session->set("tel_".$mobile,$code);

        return $code;


    }
}

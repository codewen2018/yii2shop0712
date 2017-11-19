<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/18
 * Time: 15:33
 * Company: 源码时代重庆校区
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\web\Controller;

class UserController extends Controller
{

    public $layout=false;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 3,
                'maxLength' => 3
            ],
        ];
    }

    public function actionReg(){

        $request=\Yii::$app->request;
        if ($request->isPost){

            $model=new Member();
            $model->load($request->post());
            if ($model->validate()) {
                //找到当前用户
                $member=Member::findOne(['username'=>$model]);

                //如果有用户
                if ($member){
                    //判断密码
                    if (\Yii::$app->security->validatePassword($model->password,$member->password_hash)){
                        //登录用户
                        \Yii::$app->user->login($member);

                        return $this->redirect(['index']);

                    }else{

                        echo "<script>alert('密码错误');window.history.back();</script>";


                    }


                }else{


                    echo "<script>alert('用户名错误');window.history.back();</script>";

                }
            }


            return json_encode($model->getErrors());



        }
        return $this->render('reg');

    }
}
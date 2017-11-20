<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\Member;
use Mrgoon\AliSms\AliSms;

class MemberController extends \yii\web\Controller
{

    public $layout="login";
    public $enableCsrfValidation=false;

    /**
     * 用户注册
     */
    public function actionReg()
    {
        $model=new Member();
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){

                $model->auth_key=\Yii::$app->security->generateRandomString();
                //加密密码
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                //IP
                $model->last_login_ip=ip2long($request->userIP);

                if($model->save()){
                    return $this->redirect(['index/index']);
                }

            }



        }

        return $this->render('reg',compact('model'));
    }

    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $model=new Member();

        $request=\Yii::$app->request;
        if ($request->isPost){

            $model->load($request->post());
            //找到当前用户
            $member=Member::findOne(['username'=>$model]);

            //如果有用户
            if ($member){
            //判断密码
                if (\Yii::$app->security->validatePassword($model->password,$member->password_hash)){
                    //登录用户
                    \Yii::$app->user->login($member);
                    //处理购物车同步数据
                   /* $getCookie=$request->cookies;
                    if ($getCookie->has('cart')){
                        $carts=$getCookie->getValue('cart');
                        foreach ($carts as $goodsId=>$num){
                            $cart=Cart::findOne(['goods_id'=>$goodsId,'member_id'=>\Yii::$app->user->id]);
                            if ($cart){
                                $cart->amount+=$num;
                                $cart->save();
                            }else{
                                $addCart=new Cart();
                                $addCart->goods_id=$goodsId;
                                $addCart->amount=$num;
                                $addCart->member_id=\Yii::$app->user->id;
                                $addCart->save();
                            }
                        }
                        //清空Cookie
                       $setCookie=\Yii::$app->response->cookies;
                       $setCookie->remove('cart');
                    }*/


                    (new \frontend\components\Cart())->synDb()->flush()->save();

                    return $this->redirect(['index']);

                }else{

                    echo "<script>alert('密码错误');window.history.back();</script>";


                }


            }else{


                echo "<script>alert('用户名错误');window.history.back();</script>";

            }




        }
        return $this->render('login',compact('model'));

    }
    /**
     * 短信验证
     */
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

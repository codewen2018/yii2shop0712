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
        $url=$request->get('backUrl')?$request->get('backUrl'):"index";
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


                    return $this->redirect([$url]);

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

        //1. 限制同一个手机号一天之内只能发3条

        // 1.1 数据入数据库
        // 1.2 如果数据库没有这个条手机的信息,则添加一条信息
        // 1.3 如果数据库中有这个手机信息 那么还要判断日期是不是当天的,则修改date(当天) 和times 1
        // 1.3.1 如果日期是当天,则判断times是否大于等于3,如果大于等于3,则提示已超过限额明天再发,如果没有大于等于3则给times加1
        /*
         *   tel          times       date       send_time()      code
         *  1389999          3       20171123      21555454945    1234
         *
         *
         *
         */


        //2. 同一个手机号发送验证码间隔时间不能低于1分钟

        //1234 1234     1234  1234


        //3. 解决验证不一致
        //3.1 判断当前手机号发送时间低于5分钟不随机验证,直接发上次的验证

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

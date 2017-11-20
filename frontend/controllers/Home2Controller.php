<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/19
 * Time: 9:04
 * Company: 源码时代重庆校区
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use EasyWeChat\Payment\Order;
use frontend\components\Cart;
use frontend\models\Address;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use EasyWeChat\Foundation\Application;

class Home2Controller extends BaseController
{


    public function actionIndex()
    {

        return $this->renderPartial("index");
    }

    public function actionList($id)
    {
        //当前分类
        $cate = GoodsCategory::findOne($id);

        //1. 得到包括当前分类及所有子分类    所有子分类的左值比当前分类左值大 右值小  同一棵树 'lft'>$cate->lft

        $cates = GoodsCategory::find()->where(['tree' => $cate->tree])->andWhere([
            '>=',
            'lft',
            $cate->lft
        ])->andWhere(['<=', 'rgt', $cate->rgt])->asArray()->all();


        //2. 把这些分类的ID提取出来
        $catesId = array_column($cates, 'id');
        //var_dump($catesId);exit();

        //3. 查询商品的分类ID在上面提取出来的ID中的商品 'goods_category_id in $catesId'

        $goods = Goods::find()->where(['in', 'goods_category_id', $catesId])->all();

        // var_dump($goods);exit();
        return $this->renderPartial('list', compact('goods'));


    }


    public function actionDetail($id)
    {

        $good = Goods::findOne($id);
        return $this->renderPartial("detail", compact('good'));

    }

    public function actionAddCart($goodsId, $num)
    {

        //1.判断商品有没有
        if (Goods::findOne($goodsId) === null) {

            return $this->redirect(['index']);

        }
        //2.判断是否登录
        if (\Yii::$app->user->isGuest) {

           /* $cart=new Cart();

            $cart->add($goodsId,$num);
            $cart->save();*/

            \Yii::$app->cart->add($goodsId,$num)->save();




        } else {
            //已登录 数据库
            $memberId=\Yii::$app->user->id;
            //通过用户ID和商品ID查出购物车数据
            $cart=\frontend\models\Cart::find()->where(['goods_id'=>$goodsId,'member_id'=>$memberId])->one();
            //判断不存在
            if ($cart===null){
                //执行添加操作
                $cart=new \frontend\models\Cart();
                $cart->goods_id=$goodsId;
                $cart->member_id=$memberId;
                $cart->num=$num;
            }else{
                $cart->num+=$num;
            }



            //保存
            $cart->save();
        }

        //跳转到购物车页面
        return $this->redirect(['cart']);

    }

    public function actionCart()
    {

        if (\Yii::$app->user->isGuest) {
            //1.未登录 操作cookie
            $getCookie = \Yii::$app->request->cookies;

            //1.1 得到购物车数据
            $carts = $getCookie->has("cart")?$getCookie->getValue("cart"):[];


            //var_dump($carts);

            $goods = [];
            foreach ($carts as $goodsId => $num) {


                $good = Goods::find()->where(['id' => $goodsId])->asArray()->one();
                $good['num'] = $num;

                $goods[] = $good;


            }


            //var_dump($goods);


        }else{

            //2.已登录 从数据库查
            $memberId=\Yii::$app->user->id;
            //从数据库得到当前用户所有的购物车数据
            $carts=\frontend\models\Cart::find()->where(['member_id'=>$memberId])->asArray()->all();
            $goods = [];
            //循环得到商品的信息
            foreach ($carts as $k=>$v) {

                 //查出商品
                $good = Goods::find()->where(['id' => $v['goods_id']])->asArray()->one();
                //每个商品的购买数量
                $good['num'] = $v['num'];

                $goods[] = $good;


            }

        }
        return $this->renderPartial('cart', compact('goods'));
    }

    /**
     * 专用用来做AJax
     */
    public function actionAjax($type)
    {

        switch ($type){

            case "change":
                $request = \Yii::$app->request;
                //接收参数
                $id = $request->post('id');
                $num = $request->post('num');
                //如果没有登录
                if (\Yii::$app->user->isGuest) {

                    \Yii::$app->cart->update($id,$num)->save();


                }

                //如果登录
                break;
            //如果删除操作
            case "del":

                $request = \Yii::$app->request;
                //接收参数
                $id = $request->post('id');
               //判断是否登录
                if (\Yii::$app->user->isGuest){
                   /* $cart=new Cart();
                    $cart->del($id)->save();*/
                    (new Cart())->del($id)->save();

                }else{
                    //已登录

                }

                return "success";
                break;


        }




    }

    public function actionOrder(){


        if (\Yii::$app->user->isGuest){


            return $this->redirect(['member/login','backUrl'=>Url::to(['order'])]);
        }
        //事务

        //处理订单

        //添加商品详情

        //循环订单商品

        //1.判断库存

        //2.判断商品状态


        //清空购物车


        $memberId=\Yii::$app->user->id;
        $addresss=Address::find()->where(['member_id'=>$memberId])->all();

     return $this->renderPartial('order',compact('addresss'));



    }


    public function actionTest()
    {

        $getCookie = \Yii::$app->request->cookies;


        //var_dump($getCookie->getValue('cart'));


            var_dump(microtime());
            list($usec, $sec) = explode(" ", microtime());
            $msec=round($usec*1000);

            var_dump(date_format((new \DateTime()),"u"));

    }

    public function actionWx(){
        $options=[
            /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => true,
            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => 'wx85adc8c943b8a477',         // AppID
            'secret'  => 'a687728a72a825812d34f307b630097b',     // AppSecret
            'token'   => 'your-token',          // Token
            'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！

            /**
             * 微信支付
             */
            'payment' => [
                'merchant_id'        => '1228531002',
                'key'                => 'a687728a72a825812d34f307b630097b',

            ],
            /**
             * Guzzle 全局设置
             *
             * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
             */
            'guzzle' => [
                'timeout' => 3.0, // 超时时间（秒）
                'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
            ],
        ];
        $app = new Application($options);
        $payment = $app->payment;
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => 'iPad ',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '00000001',
            'total_fee'        => 1, // 单位：分
            'notify_url'       => Url::to(['ok'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
           // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new Order($attributes);

        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }

        var_dump($result);
    }
    public function actionOk(){
        $options=[
            /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => true,
            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => 'wx85adc8c943b8a477',         // AppID
            'secret'  => 'a687728a72a825812d34f307b630097b',     // AppSecret
            'token'   => 'your-token',          // Token
            'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！

            /**
             * 微信支付
             */
            'payment' => [
                'merchant_id'        => '1228531002',
                'key'                => 'a687728a72a825812d34f307b630097b',

            ],
            /**
             * Guzzle 全局设置
             *
             * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
             */
            'guzzle' => [
                'timeout' => 3.0, // 超时时间（秒）
                'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
            ],
        ];
        $app = new Application($options);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
        /*    $order = 查询订单($notify->out_trade_no);
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 'paid';
            } else { // 用户支付失败
                $order->status = 'paid_fail';
            }*/
           $cart=new \frontend\models\Cart();
            $cart->member_id=11;
            $cart->goods_id=1;
            $cart->num=5;
            $cart->save();
           // $order->save(); // 保存订单
            return true; // 返回处理完成
        });
        return $response;
    }
}
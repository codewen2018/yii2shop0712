<?php

namespace frontend\controllers;

use backend\models\Goods;
use EasyWeChat\QRCode\QRCode;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use EasyWeChat\Foundation\Application;

class OrderController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        //1. 未登录跳登录
        if (\Yii::$app->user->isGuest) {

            //$orderUrl=Url::to(['order/index']);
            return $this->redirect(['member/login', 'backUrl' => 'order/index']);

        }
        //2.查出地址
        $memberId = \Yii::$app->user->id;
        $addresss = Address::find()->where(['member_id' => $memberId])->all();

        //3.从数据库购物车中取出商品

        //3.1 从数据库得到当前用户所有的购物车数据
        $carts = \frontend\models\Cart::find()->where(['member_id' => $memberId])->asArray()->all();
        $goods = [];
        //总价
        $totalPrice = 0;
        //3.2循环得到商品的信息
        foreach ($carts as $k => $v) {
            //查出商品
            $good = Goods::find()->where(['id' => $v['goods_id']])->asArray()->one();
            //每个商品的购买数量
            $good['num'] = $v['num'];
            $totalPrice += $good['shop_price'] * $good['num'];
            $goods[] = $good;

        }
        $request = \Yii::$app->request;
        if ($request->isPost) {

            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事务

            try {
                //1. 把订单表order 一一赋值 然后保存
                $order = new Order();

                //地址
                $address = Address::findOne($request->post("address_id"));

                $order->member_id = $memberId;
                $order->name = $address->name;
                $order->province = $address->province;
                $order->city = $address->city;
                $order->area = $address->county;
                $order->detail_address = $address->address;
                $order->tel = $address->mobile;
                $order->delivery_id = $request->post("delivery");
                $order->delivery_name = \Yii::$app->params["delivers"][$order->delivery_id - 1]['name'];
                $order->delivery_price = \Yii::$app->params["delivers"][$order->delivery_id - 1]['price'];
                $order->payment_id = $request->post("pay");
                $order->payment_name = \Yii::$app->params["payType"][$order->payment_id - 1]['name'];;
                $order->status = 1;//等待付款
                $order->trade_no = date("ymdHis") . rand(1000, 9999);
                $order->create_time = time();
                //总价

                $order->price = $totalPrice + $order->delivery_price;


                //保存数据

                $order->save();
                //2. 把订单商品入order_detail表


                foreach ($goods as $good) {


                    $goodsModel = Goods::findOne($good['id']);
                    //判断库存是否充足
                    if ($good['num'] > $goodsModel->stock) {
                        //抛出异常
                        throw new Exception("库存不足,请重新下单");
                    };
                    $orderDetail = new OrderDetail();

                    $orderDetail->order_info_id = $order->id;//订单Id
                    $orderDetail->goods_id = $good['id'];
                    $orderDetail->amount = $good['num'];
                    $orderDetail->goods_name = $good['name'];
                    $orderDetail->logo = $good['logo'];
                    $orderDetail->price = $good['shop_price'];
                    $orderDetail->total_price = $good['shop_price'] * $good['num'];
                    $orderDetail->save();

                    //减库存
                    $goodsModel->stock -= $good['num'];
                    $goodsModel->save();

                }


                //3.清空购物车
                Cart::deleteAll(['member_id' => $memberId]);


                $transaction->commit();//事务提交

            } catch (Exception $e) {

                $transaction->rollBack();//事务回滚

                //  var_dump($e->getMessage());
                echo "<script>alert('" . $e->getMessage() . "')</script>";
                //throw $e;
            }
            //var_dump($request->post());
            //  exit;


        }


        return $this->renderPartial('index', compact('goods', 'addresss', 'totalPrice'));
    }


    public function actionPay($orderId)
    {

        //查询当前订单
        $orderModel = Order::findOne($orderId);

        $orderDetail = OrderDetail::find()->where(['order_info_id' => $orderId])->one();


        $app = new Application(\Yii::$app->params['wechatOption']);
        $payment = $app->payment;
        $attributes = [
            'trade_type' => 'NATIVE', // JSAPI，NATIVE，APP... 交易类型
            'body' => '京西商城订单',//商品描述
            'detail' => $orderDetail->goods_name . "...",//商品详情
            'out_trade_no' => $orderModel->trade_no,//订单号
            'total_fee' => $orderModel->price * 100, // 单位：分
            'notify_url' => Url::to(['ok'], true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        //生成订单
        $order = new \EasyWeChat\Payment\Order($attributes);

        //调用微信接口统一下单
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepayId = $result->prepay_id;
            //var_dump($result->code_url);
            //  ob_start();
            header('Content-Type: image/png');
            //  ob_clean();
            return \dosamigos\qrcode\QrCode::png($result->code_url, false, 3, 6);
        }

        //   var_dump($result);
    }

    public function actionDemo()
    {
        return $this->render('demo');
    }

    public function actionOk()
    {

        $app = new Application(\Yii::$app->params['wechatOption']);
        $response = $app->payment->handleNotify(function ($notify, $successful) {
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            // $order = 查询订单($notify->out_trade_no);
            //查询是否存在此订单
            $order = Order::find()->where(['trade_no' => $notify->out_trade_no])->one();
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status != 1) { // 如果不是等付款就说明已经操作
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                // $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 2;
            } else { // 用户支付失败
                // $order->status = 'paid_fail';
            }
            $order->save(); // 保存订单
            return true; // 返回处理完成
        });
        return $response;


    }


    public function actionClear()
    {

        //1.找出超时订单  15分钟 time()-create_time>15*60===>time()-15*60>create_time

        $orders = Order::find()->where(['status' => 1])->andWhere(['<', "create_time", time() - 900])->all();
        //1.1 得到订单所有ID
        $ordersIds = ArrayHelper::map($orders, 'id', 'id');
        //2.更新订单状态为0 已取消
        $orderSave=Order::updateAll(['status' => 0], ['in', 'id', $ordersIds]);
         // var_dump($orderSave);exit;
        //3. 把库存给加回去
        if ($orderSave){
            //3.1 循环订单Id
           foreach ($ordersIds as $ordersId){
               //3.2找出当前订单所有商品信息
               $orderDetails=OrderDetail::find()->where(['order_info_id'=>$ordersId])->all();
               //3.3 循环商品 加库存
               foreach ($orderDetails as $orderDetail){
                   Goods::updateAllCounters(['stock'=>$orderDetail->amount],['id'=>$orderDetail->goods_id]);
               }
           }






        }


    }


}

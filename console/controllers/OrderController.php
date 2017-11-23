<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/23
 * Time: 9:47
 * Company: 源码时代重庆校区
 */

namespace console\controllers;


use yii\console\Controller;
use frontend\models\OrderDetail;
use frontend\models\Order;
use yii\helpers\ArrayHelper;
use backend\models\Goods;

class OrderController extends Controller
{
    public function actionClear()
    {

       while (true){
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
           if ($ordersIds){
               echo date("Y-m-d H:i:s")." 订单号:".implode(",",$ordersIds)." has been complete".PHP_EOL;
           }else{
               echo date("Y-m-d H:i:s")." order not find".PHP_EOL;
           }

           sleep(5);
       }



    }
}
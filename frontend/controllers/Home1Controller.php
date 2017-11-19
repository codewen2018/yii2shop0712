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
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;

class Home1Controller extends BaseController
{


    public function actionIndex(){

        return $this->renderPartial("index");
    }

    public function actionList($id){
        //当前分类
        $cate=GoodsCategory::findOne($id);

        //1. 得到包括当前分类及所有子分类    所有子分类的左值比当前分类左值大 右值小  同一棵树 'lft'>$cate->lft

        $cates=GoodsCategory::find()->where(['tree'=>$cate->tree])->andWhere(['>=','lft',$cate->lft])->andWhere(['<=','rgt',$cate->rgt])->asArray()->all();



        //2. 把这些分类的ID提取出来
        $catesId=array_column($cates,'id');
        //var_dump($catesId);exit();

        //3. 查询商品的分类ID在上面提取出来的ID中的商品 'goods_category_id in $catesId'

        $goods=Goods::find()->where(['in','goods_category_id',$catesId])->all();

       // var_dump($goods);exit();
        return $this->renderPartial('list',compact('goods'));


    }


    public function actionDetail($id)
    {

        $good=Goods::findOne($id);
        return $this->renderPartial("detail",compact('good'));

    }

    public function actionAddCart($goodsId,$num){

        //判断商品有没有
           if (Goods::findOne($goodsId)===null) {

             return $this->redirect(['index']);

           }

          if (\Yii::$app->user->isGuest){
              //1.如果没用登录 cookie  数据类型数组 ['goodsId1'=>'num1','goodsId2'=>'num2']

              //2.拼数据
              $cart=[$goodsId=>$num];

              //2.1 获得Cookie中购物车的数据
              $getCookie=\Yii::$app->request->cookies;
              $cartOld=$getCookie->has("cart")?$getCookie->getValue('cart'):[];

             // var_dump($cartOld);
              //判断购物车数据中有没有当前商品
              //key_exists($goodsId,$cartOld)
              if (isset($cartOld[$goodsId])) {
                  //如果存在则加num
                  $cartOld[$goodsId]=$cartOld[$goodsId]+$num;
              }else{
                 //不存在追加
                 $cartOld[$goodsId]=$num;
              }
              //var_dump($cartOld);//exit();
              //3. 存Cookie
              $setCookie=\Yii::$app->response->cookies;

              //生成Cookie对象
              $cartCookie=new Cookie(
                  [
                      'name'=>'cart',
                      'value'=>$cartOld,
                      'expire'=>time()+3600*24*7
                  ]
              );

              //把Cookie对象添加到Cookie里
              $setCookie->add($cartCookie);

              //跳转到购物车页面

              return $this->redirect(['cart']);


          }else{
            //2.已登录 数据库

          }


    }

    public function actionCart(){

        if (\Yii::$app->user->isGuest) {
            //1.未登录 操作cookie
            $getCookie=\Yii::$app->request->cookies;

            //1.1 得到购物车数据
            $carts=$getCookie->getValue("cart");


            //var_dump($carts);

            $goods=[];
            foreach ($carts as $goodsId=>$num){


                $good=Goods::find()->where(['id'=>$goodsId])->asArray()->one();
                $good['num']=$num;

                $goods[]=$good;


            }



 //var_dump($goods);





        }




        //2.已登录



        return $this->renderPartial('cart',compact('goods'));
    }

    public function actionChangeCart(){

        $request=\Yii::$app->request;
        //接收参数
        $id=$request->post('id');
        $num=$request->post('num');

        //如果没有登录
        if (\Yii::$app->user->isGuest){

            $getCookie=\Yii::$app->request->cookies;
            //取出Cookie
            $cart=$getCookie->getValue('cart');

           // return Json::encode($cart);

            $cart[$id]=$num;




            $setCookie=\Yii::$app->response->cookies;

            $cartCookie=new Cookie(
                [
                    'name'=>"cart",
                    'value'=>$cart,
                    'expire'=>time()+3600
                ]
            );
            $setCookie->add($cartCookie);







        }

        //如果登录


    }

    public function actionTest(){

        $getCookie=\Yii::$app->request->cookies;


        var_dump($getCookie->getValue('cart'));
    }
}
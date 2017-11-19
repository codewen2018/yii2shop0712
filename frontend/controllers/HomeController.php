<?php
/**
 * @var $cart \frontend\components\CartTest
 */
namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\components\CartTest;
use frontend\models\Cart;
use yii\web\Cookie;

class HomeController extends \yii\web\Controller
{
    public $layout=false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList($id){

        $cate=GoodsCategory::findOne($id);

        $cates=GoodsCategory::find()->where(['tree'=>$cate->tree])->andWhere(['>=','lft',$cate->lft])->andWhere(['<=','rgt',$cate->rgt])->asArray()->all();

        $catesIds=array_column($cates,'id');

        $goods=Goods::find()->where(['in','goods_category_id',$catesIds])->all();



        return $this->render('list.php',compact('cate','goods'));
    }

    public function actionDetail($id){
        $good=Goods::findOne($id);
        return $this->render('detail.php',compact('good'));
    }

    public function actionAddCart($goodsId,$num)
    {

        if (Goods::findOne($goodsId)===null){

            return $this->redirect("index");

        }

        //1. 用户未登录把商品ID和数量存在Cookie
        if (\Yii::$app->user->isGuest){

           /* $getCookie=\Yii::$app->request->cookies;

            if ($getCookie->has('cart')) {
                //如果存在Cookie,先把Cookie取出来
                $cart=$getCookie->getValue('cart');
               //判断是否存在
                if (key_exists($goodsId,$cart)){
                    $cart[$goodsId]+=$num;
                }else{
                    $cart[$goodsId]=$num;
                }
            }else{
                $cart=[$goodsId=>$num];
            }


            $cookie=\Yii::$app->response->cookies;




            $cartCookie=new Cookie(
                [
                    'name'=>'cart',
                    'value'=>$cart,
                    'expire'=>time()+3600,

                ]
            );

            $cookie->add($cartCookie);*/
            //$cart=\Yii::$app->cartTest;

            \Yii::$app->cartTest->addCart($goodsId,$num)->saveCart();




        }else{
            //2.用户已登录把商品Id和数量放入数据库


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

        $this->redirect(['cart']);

    }

    public function actionCart(){
        //1.没有登录
        if (\Yii::$app->user->isGuest){
            $getCookie=\Yii::$app->request->cookies;

            $carts=$getCookie->has('cart')?$getCookie->getValue('cart'):[];
            $models=[];
            foreach ($carts as $goodsId=>$num){
               $good= Goods::find()->where(['id'=>$goodsId])->asArray()->one();
             if ($good){
                 $good['num']=$num;


                 $models[]=$good;
             }
            }

           //var_dump($models);exit;

        }


        return $this->render('cart',compact('models'));
    }

    public function actionTest(){
        $cookie=\Yii::$app->request->cookies;

        var_dump($cookie->getValue('cart'));


    }

    public function actionChangeCart(){

        $request=\Yii::$app->request;

        $id=$request->post('id');
        $num=$request->post('num');

          //如果没有登录
        if (\Yii::$app->user->isGuest){
           /* $getCookie=\Yii::$app->request->cookies;

            $cart=$getCookie->getValue('cart');

            $cart[$id]=$num;


            $setCookie=\Yii::$app->response->cookies;

            $cartCookie=new Cookie(
               [
                   'name'=>"cart",
                   'value'=>$cart,
                   'expire'=>time()+3600
               ]
            );
            $setCookie->add($cartCookie);*/
           \Yii::$app->cartTest->updateCart($id,$num)->saveCart();
        }

        //如果登录


    }


}

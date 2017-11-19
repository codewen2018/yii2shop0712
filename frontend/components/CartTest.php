<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/19
 * Time: 16:21
 * Company: 源码时代重庆校区
 */

namespace frontend\components;

use frontend\models\Cart;
use yii\base\Component;
use yii\base\Exception;
use yii\web\Cookie;

class CartTest extends Component
{

    private $_cart = [];


    public function __construct(array $config = [])
    {

        $getCookie = \Yii::$app->request->cookies;

        if ($getCookie->has("cart")) {
            $cart = $getCookie->getValue('cart');
        } else {

            $cart = [];
        }

        $this->_cart = $cart;
        parent::__construct($config);
    }

    public function getCart()
    {
        return $this->_cart;
    }

    public function addCart($goodsId, $num)
    {

        //判断Cookie中有没有当前商品Id
        if (key_exists($goodsId, $this->_cart)) {
            $this->_cart[$goodsId] += $num;
        } else {
            $this->_cart[$goodsId] = $num;
        }

        return $this;
    }

    public function updateCart($goodsId, $num)
    {
        $this->_cart[$goodsId] = $num;
        return $this;
    }

    public function delCart($goodsId)
    {
        unset($this->_cart[$goodsId]);
        return $this;
    }

    public function flushCart()
    {
        $this->_cart = [];
        return $this;
    }

    public function synDb()
    {
        if (\Yii::$app->user->isGuest) {
            throw  new Exception("只有登录用户才能操作");
        }

        $memberId = \Yii::$app->user->id;

        foreach ($this->_cart as $goodsId => $num) {

            $cart = Cart::findOne(['goods_id' => $goodsId, 'member_id' => $memberId]);

            if ($cart === null) {
                $cart = new Cart();
                $cart->member_id = $memberId;
                $cart->goods_id = $goodsId;
                $cart->amount = $num;
            } else {

                $cart->amount += $num;
            }

            $cart->save();


        }

        return $this;
    }

    public function saveCart()
    {
        $setCookie = \Yii::$app->response->cookies;

        $cartCookie = new  Cookie(
            [
                'name'=>'cart',
                'value'=>$this->_cart,
                'expire'=>time()+\Yii::$app->params['cartExpireTime']
            ]
        );

        $setCookie->add($cartCookie);


    }

}
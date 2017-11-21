<?php
/* @var $this yii\web\View */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/fillin.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">

    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php include_once Yii::getAlias("@app/views/common/nav.php") ?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <form method="post" action="">
        <input type="hidden" name="_csrf-frontend" value="<?=Yii::$app->request->csrfToken?>">
        <div class="fillin_bd">
            <!-- 收货人信息  start-->
            <div class="address">
                <h3>收货人信息 <a href="javascript:;" id="address_modify">[修改]</a></h3>
                <div class="address_info">

                    <?php foreach ($addresss as $address): ?>
                        <p>
                            <input type="radio" value="<?= $address->id ?>"
                                   name="address_id" <?= $address->status ? "checked" : "" ?>/>

                            <?php
                            echo $address->name;
                            echo " ";
                            echo $address->mobile;
                            echo " ";
                            echo $address->province;
                            echo " ";
                            echo $address->city;
                            echo " ";
                            echo $address->county;
                            echo " ";
                            echo $address->address;
                            echo " ";

                            ?>
                        </p>
                    <?php endforeach; ?>
                </div>


            </div>
            <!-- 收货人信息  end-->

            <!-- 配送方式 start -->
            <div class="delivery">

                <div class="delivery_info">
                    <table width="600">
                        <thead>
                        <tr>
                            <th class="col1">送货方式</th>
                            <th class="col2">运费</th>
                            <th class="col3">运费标准</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach (Yii::$app->params['delivers'] as $k1 => $v1): ?>
                            <tr <?= $k1 == 0 ? 'class="cur"' : "" ?>>
                                <td>


                                    <input type="radio" name="delivery"
                                           data_price="<?= $v1['price'] ?>" <?= $k1 == 0 ? 'checked' : "" ?>
                                           value="<?= $v1['id'] ?>"/><?= $v1['name'] ?>
                                </td>
                                <td>￥<?= $v1['price'] ?></td>
                                <td><?= $v1['info'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            </div>
            <!-- 配送方式 end -->

            <!-- 支付方式  start-->
            <div class="pay">
                <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
                <div class="pay_info">
                    <div class="pay_select">
                        <table>
                            <?php foreach (Yii::$app->params['payType'] as $k2 => $v2): ?>


                                <tr <?= $k2 == 0 ? 'class="cur"' : "" ?>>

                                    <td class="col1"><input type="radio" name="pay" <?= $k2 == 0 ? 'checked' : "" ?>
                                                            value="<?= $v2['id'] ?>"/><?= $v2['name'] ?></td>
                                    <td class="col2"><?= $v2['info'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>


            </div>
            <!-- 支付方式  end-->


            <!-- 商品清单 start -->
            <div class="goods">
                <h3>商品清单</h3>
                <table>
                    <thead>
                    <tr>
                        <th class="col1">商品</th>
                        <th class="col3">价格</th>
                        <th class="col4">数量</th>
                        <th class="col5">小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($goods as $good): ?>
                        <tr>
                            <td class="col1"><a
                                        href="<?= \yii\helpers\Url::to(['home1/detail', 'id' => $good['id']]) ?>"><img
                                            src="<?= $good['logo'] ?>" alt=""/></a> <strong><a
                                            href="<?= \yii\helpers\Url::to([
                                                'home1/detail',
                                                'id' => $good['id']
                                            ]) ?>"><?= $good['name'] ?></a></strong></td>
                            <td class="col3">￥<?= $good['shop_price'] ?></td>
                            <td class="col4"> <?= $good['num'] ?></td>
                            <td class="col5"><span>￥<?= $good['shop_price'] * $good['num'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul>
                                <li>
                                    <span>4 件商品，总商品金额：</span>
                                    <em>￥<span id="goods_price"><?= $totalPrice ?></span></em>
                                </li>

                                <li>
                                    <span>运费：</span>
                                    <em id="delivers_price">￥<?= Yii::$app->params['delivers'][0]['price'] ?></em>
                                </li>
                                <li>
                                    <span>应付总额：</span>
                                    <em class="total_price">￥<?= $totalPrice + Yii::$app->params['delivers'][0]['price'] ?></em>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- 商品清单 end -->

        </div>

        <div class="fillin_ft">

            <input type="submit" value="" style="
        float: right;
    display: inline;
    width: 135px;
    height: 36px;
    background: url(/images/order_btn.jpg) 0 0 no-repeat;
    vertical-align: middle;
    margin: 7px 10px 0;">
            <p>应付总额：<strong class="total_price">￥<?= $totalPrice + Yii::$app->params['delivers'][0]['price'] ?>
                    元</strong></p>

        </div>

    </form>
</div>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。 ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt=""/></a>
        <a href=""><img src="/images/kexin.jpg" alt=""/></a>
        <a href=""><img src="/images/police.jpg" alt=""/></a>
        <a href=""><img src="/images/beian.gif" alt=""/></a>
    </p>
</div>
<!-- 底部版权 end -->

<script>
    $(function () {
        //修改快递方式
        $("[name='delivery']").change(function () {
            // alert($(this).attr('data_price'));
            //运费
            var price = $(this).attr('data_price') - 0;
            $("#delivers_price").text("￥" + price);
            //算总价
            $(".total_price").text("￥" + ($("#goods_price").text() - 0 + price))
        });


    });


</script>
</body>
</html>


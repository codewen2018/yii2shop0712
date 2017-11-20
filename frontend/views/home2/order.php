<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify">[修改]</a></h3>
            <div class="address_info">
                <?php foreach ($addresss as $address): ?>
                    <p>
                        <input type="radio" value="<?= $address->id ?>" name="address_id" <?=$address->status?"checked":""?>/><?php
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
                        ?> </p>
                <?php endforeach; ?>

            </div>

            <div class="address_select none">
                <ul>
                    <li class="cur">
                        <input type="radio" name="address" checked="checked"/>王超平 北京市 昌平区 建材城西路金燕龙办公楼一层 13555555555
                        <a href="">设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li>
                    <li>
                        <input type="radio" name="address"/>王超平 湖北省 武汉市 武昌 关山光谷软件园1号201 13333333333
                        <a href="">设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li>
                    <li><input type="radio" name="address" class="new_address"/>使用新地址</li>
                </ul>
            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
            <div class="delivery_info">
                <p><?=Yii::$app->params['delivers'][0]['name']?></p>

            </div>

            <div class="delivery_select none">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (Yii::$app->params['delivers'] as $k=>$v):?>
                    <tr <?=$k==0?"class='cur'":""?>>

                        <td>

                            <input type="radio" name="delivery" delivery-price="<?=$v['price']?>" <?=$k==0?"checked":""?> value="<?=$v['id']?>"/><?=$v['name']?>
                        </td>
                        <td>￥<?=$v['price']?></td>
                        <td><?=$v['info']?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <a href="javascript:;" class="confirm_btn" id="btn_delivery"><span>确认送货方式</span></a>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
            <div class="pay_info">
                <p><?=Yii::$app->params['payType'][0]['name']?></p>
            </div>

            <div class="pay_select none">
                <table>
                    <?php foreach (Yii::$app->params['payType'] as $k1=>$payType):?>
                    <tr <?=$k1==0?'class="cur"':''?>>
                        <td class="col1"><input type="radio" name="pay" <?=$k1==0?'checked':''?>/><?=$payType['name']?></td>
                        <td class="col2"><?=$payType['info']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
                <a href="javascript:;" class="confirm_btn" id="btn_pay_type"><span>确认支付方式</span></a>
            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->

        <!-- 发票信息 end-->

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
                <tr>
                    <td class="col1"><a href=""><img src="/images/cart_goods1.jpg" alt=""/></a> <strong><a href="">【1111购物狂欢节】惠JackJones杰克琼斯纯羊毛菱形格</a></strong>
                    </td>
                    <td class="col3">￥499.00</td>
                    <td class="col4"> 1</td>
                    <td class="col5"><span>￥499.00</span></td>
                </tr>
                <tr>
                    <td class="col1"><a href=""><img src="/images/cart_goods2.jpg" alt=""/></a> <strong><a href="">九牧王王正品新款时尚休闲中长款茄克EK01357200</a></strong>
                    </td>
                    <td class="col3">￥102.00</td>
                    <td class="col4">1</td>
                    <td class="col5"><span>￥102.00</span></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span>4 件商品，总商品金额：</span>
                                <em>￥<span id="goodsTotalPrice">5316.00</span></em>
                            </li>

                            <li>
                                <span>运费：</span>
                                <em>￥<span id="driverPrice">10.00</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<span class="totalPrice">5316.00</span></em>
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
        <a href=""><span>提交订单</span></a>
        <p>应付总额：<strong>￥<span class="totalPrice">5316.00</span>元</strong></p>

    </div>
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

    //总金额计算
    function total() {
         $(".totalPrice").text(($("#goodsTotalPrice").text()-0)+parseFloat($("#driverPrice").text()));

    }
    total();
    //修改支付方式
    $("#btn_delivery").click(function () {
        $(this).parent().prev().prev().find('a').show();
        $(".delivery_info").show();
        $(".delivery_select").hide();

        $(".delivery_info>p").text($("input[name='delivery']:checked").parent().text());

        $("#driverPrice").text($("input[name='delivery']:checked").attr('delivery-price'));
        total();
    });

    //支付方式修改
    $("#btn_pay_type").click(function(){
        $(this).parent().hide();
        $(this).parent().prev().show();
        $(this).parent().prev().prev().find('a').show();


        $(".pay_info>p").text($("input[name='pay']:checked").parent().text());


    })


</script>
</body>
</html>


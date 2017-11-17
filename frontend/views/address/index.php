<?php
/* @var $this yii\web\View */

$this->registerJsFile("@web/js/address.js",['depends'=>\yii\web\JqueryAsset::className()]);
?>
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <dl>
                <dt>1.许坤 北京市 昌平区 仙人跳区 仙人跳大街 17002810530 </dt>
                <dd>
                    <a href="">修改</a>
                    <a href="">删除</a>
                    <a href="">设为默认地址</a>
                </dd>
            </dl>
            <dl class="last"> <!-- 最后一个dl 加类last -->
                <dt>2.许坤 四川省 成都市 高新区 仙人跳大街 17002810530 </dt>
                <dd>
                    <a href="">修改</a>
                    <a href="">删除</a>
                    <a href="">设为默认地址</a>
                </dd>
            </dl>

        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <form action="" name="address_form">
                <ul>
                    <li>
                        <label for=""><span>*</span>收 货 人：</label>
                        <input type="text" name="" class="txt" />
                    </li>
                    <li>
                        <label for=""><span>*</span>所在地区：</label>
                        <select name="Address[province]" id="province" onchange="doProvAndCityRelation();">
                            　　<option id="choosePro"value="-1">请选择省份</option>
                        </select>

                        <select name="Address[city]" id="citys" onchange="doCityAndCountyRelation();">
                            <option id='chooseCity' value='-1'>请选择市</option>
                        </select>

                        <select name="Address[county]" id="county">
                            <option id='chooseCounty' value='-1'>请选择区/县</option>
                        </select>
                    </li>
                    <li>
                        <label for=""><span>*</span>详细地址：</label>
                        <input type="text" name="" class="txt address"  />
                    </li>
                    <li>
                        <label for=""><span>*</span>手机号码：</label>
                        <input type="text" name="" class="txt" />
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" name="" class="check" />设为默认地址
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" name="" class="btn" value="保存" />
                    </li>
                </ul>
            </form>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
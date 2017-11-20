<?php
return [
    'adminEmail' => 'admin@example.com',
    'cartExpireTime' => 3600 * 24 * 7,

    //送货方式
    'delivers' => [
        [
            'id'=>1,
            'name'=>'顺丰',
            'price'=>10,
            'info'=>'非常快',
             ],
        [
            'id'=>2,
            'name'=>'菜鸟',
            'price'=>5,
            'info'=>'非常慢',
        ],
    ],
    'payType' => [
        [
            'id'=>1,
            'name' => '在线支付',
            'info' => '即时到帐，支持绝大数银行借记卡及部分银行信用卡'
        ],
        [
            'id'=>2,
            'name' => '微信支付',
            'info' => '微信支付，支持绝大数银行借记卡及部分银行信用卡'
        ],
        [
            'id'=>3,
            'name' => '货到付款',
            'info' => '货到付款，支持绝大数银行借记卡及部分银行信用卡'
        ],


    ],

];

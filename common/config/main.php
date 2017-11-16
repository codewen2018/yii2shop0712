<?php
return [
    //语言
    'language'=>'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'alidayu' => [
            'class' => 'chocoboxxf\Alidayu\Alidayu',
            'appKey' => 'LTAIZtnogmyPTgk0', // 淘宝开发平台App Key
            'appSecret' => '0ha8kjuh1NZ6gODvjySuGGR2xFee2z', // 淘宝开发平台App Secret
            //'partnerKey' => 'PARTNER_NAME_AXN', // 阿里大鱼提供的第三方合作伙伴使用的KEY
            'env' => 'sandbox', // 使用环境，分sandbox（测试环境）, production（生产环境）
        ]
    ],
];

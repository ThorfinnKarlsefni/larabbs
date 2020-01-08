<?php

return [
    // HTTP 请求的超时时间
    'timeout' => 5.0,

    //默认发送配置
    'default' => [

        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        'gateways' => [
            'yunpian',
        ],
    ],

    //可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'yunpian' => [
            'api_key' => env('YUNPIAN_API_KEY'),
        ],
    ],
];
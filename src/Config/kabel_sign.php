<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/01/18 10:07,
 * @LastEditTime: 2022/01/18 10:07
 */

/**
 * Api统一签名加密校验
 */
return [
    'default'=> 'kabel',
    'kabel' => [ // 卡百利
        'is_open' => env('SIGN_KABEL_IS_OPEN', false), // 是否开放签名
        'timeout' => env('SIGN_KABEL_TIMEOUT', 3000), // 签名过期时间 (毫秒)
        'app_key' => env('SIGN_KABEL_APP_KEY', '6512190578581569536'),
        'secret' => env('SIGN_KABEL_APP_SECRET', '3b1829b6e84d0b2a33d1704a66e226921'),
    ],
    'framework' => [ // 卡百利
        'is_open' => env('SIGN_FRAMEWORK_IS_OPEN', true), // 是否开放签名
        'timeout' => env('SIGN_FRAMEWORK_TIMEOUT', 3000), // 签名过期时间 (毫秒)
        'app_key' => env('SIGN_FRAMEWORK_APP_KEY', '6512190578581569536'),
        'secret' => env('SIGN_FRAMEWORK_APP_SECRET', '3b1829b6e84d0b2a33d1704a66e226921'),
    ],
    //营销、账号....
];

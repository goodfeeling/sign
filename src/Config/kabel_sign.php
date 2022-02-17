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
    'default'=>  env('SIGN_DEFAULT', 'kabel'), //默认签名
    'kabel' => [ // 卡百利
        /**
         *  是否开放签名 false 不校验 true 校验
         */
        'is_open' => env('SIGN_KABEL_IS_OPEN', true),
        /**
         * // 签名过期时间 (秒)
         */
        'timeout' => env('SIGN_KABEL_TIMEOUT', 3000),
        /**
         * appkey
         */
        'app_key' => env('SIGN_KABEL_APP_KEY', ''),
        /**
         * secret
         */
        'secret' => env('SIGN_KABEL_APP_SECRET', ''),
    ],
    'framework' => [ // 基建
        'is_open' => env('SIGN_FRAMEWORK_IS_OPEN', true), // 是否开放签名
        'timeout' => env('SIGN_FRAMEWORK_TIMEOUT', 3000), // 签名过期时间 (秒)
        'app_key' => env('SIGN_FRAMEWORK_APP_KEY', ''),
        'secret' => env('SIGN_FRAMEWORK_APP_SECRET', ''),
    ],
    'skip_sign_rule'=>env('SKIP_SIGN_RULE', ''),
];

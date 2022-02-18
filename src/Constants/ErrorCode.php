<?php
/**
 * @Author: yaozhiwen <13538863962@163.com>,
 * @Date: 2022/1/4 11:19,
 * @LastEditTime: 2022/1/4 11:19,
 * @Copyright: 2020 Kabel Inc. 保留所有权利。
 */

namespace Kabel\Sign\Constants;


class ErrorCode
{
    public const DATA_IS_NULL = ['数据不存在！',1901];
    public const SIGN_ERROR = ['签名错误！',1902];
    public const TIMESTAME_ERROR = ['缺少参数时间戳t！',1903];
    public const SIGN_TIMEOUT = ['验签sign失效！',1905];
    public const SIGN_NOT_FOUND = ['缺少参数验签sign！',1906];
    public const NONCE_NOT_FOUND = ['缺少生成签名需要的随机值！',1907];
    public const PARAMS_ERROR = ['参数错误！',1908];
    public const DATA_ERROR = ['数据有误！',1908];
    public const APP_KEY_ERROR = ['Appkey有误！',1908];
    public const CRYPTO_ERROR = ['数据解密失败！',1909];
    public const NONCE_ERROR = ['nonce is error！',1910];
    public const SIGN_CONFIG_NOT_FOND = ['请配置签名信息',1911];
    public const SIGN_COMPONENT_ERROR = ['签名模块异常，请检查是否配置签名！',1912];
}

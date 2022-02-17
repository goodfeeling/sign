<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 12:02,
 * @LastEditTime: 2022/1/18 12:02,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Interfaces;


use Kabel\Sign\Exceptions\SignException;

interface SignServiceInterface
{
    /**
     * @param  array  $params
     *  必填参数:
     *  timestamp: 时间戳
     *  nonce: 随机数
     *  请求的其它参数...
     * @param string $signType
     *  签名类型
     * @return false|string
     * @throws SignException
     */
    public function makeSignature($params = array(),string $signType);

    /**
     * 递归构建参数
     * @param  array  $params
     * @param  int  $rfc
     * @return string
     */
    public function loopArraySign($params = array(), $rfc = 3986);
}

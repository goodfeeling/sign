<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 12:02,
 * @LastEditTime: 2022/1/18 12:02,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Services;


use Kabel\Sign\Constants\ErrorCode;
use Kabel\Sign\Exceptions\CustomException;
use Kabel\Sign\Interfaces\SignServiceInterface;

class SignService implements SignServiceInterface
{
    /**
     * 设置参数
     * @param $params
     * @param  $signType
     * @return mixed
     */
    public static function setParams(array &$params, $signType){
        //获取appSecret
        $config = config("kabel_sign.$signType");
        $params['t'] = time();
        $params['appkey'] = $config['app_key'];
        // 签名
        $params['sign'] = genSign($params, $config['secret']);
        // 生成随机数防止重放攻击
        $params['nonce'] = app(CryptoService::class)->createRandomStr();
        return $params;
    }

    /**
     * @param  array  $params
     *  必填参数:
     *      timestamp: 时间戳
     *      nonce: 随机数
     *      请求的其它参数...
     * @param string $signType
     *  签名类型
     * @return false|string
     * @throws CustomException
     */
    public function makeSignature($params = array(),string $signType = 'kabel')
    {
        if (!is_array($params)) {
            throw new CustomException(ErrorCode::PARAMS_ERROR);
        }
        //获取appSecret
        $config = config("kabel_sign.$signType");
        //获取sign
        $signData = $this->loopArraySign($params, 3986);
        if (!$config['secret']) {
            return false;
        }
        return strtoupper(md5($signData.$config['secret']));
    }

    /**
     * 递归构建参数
     * @param  array  $params
     * @param  int  $rfc
     * @return string
     */
    public function loopArraySign($params = array(), $rfc = 3986)
    {
        $sign = "";
        ksort($params);
        foreach ($params as $k => $v) {
            if (is_array($v)) {
                $sign .= "{$k}";
                $sign .= $this->loopArraySign($v, $rfc);
            } else {
                $v = $rfc == 3986 ? rawurlencode($v) : urlencode($v);
                $sign .= "{$k}{$v}";
            }
        }
        return $sign;
    }
}

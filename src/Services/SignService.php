<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 12:02,
 * @LastEditTime: 2022/1/18 12:02,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Services;


use Illuminate\Support\Facades\Log;
use Kabel\Sign\Constants\ErrorCode;
use Kabel\Sign\Enums\ClientEnum;
use Kabel\Sign\Exceptions\SignException;
use Kabel\Sign\Interfaces\SignServiceInterface;

class SignService implements SignServiceInterface
{
    /**
     * 设置参数
     * @param  array  $params
     * @param  $signType
     * @return mixed
     * @throws SignException
     */
    public static function setParams(array &$params, $signType = null){
        try {
            $signType = $signType ?:config("kabel_sign.default");
            //获取appSecret
            $config = config("kabel_sign.$signType");
            if (!$config) {
                throw new SignException(ErrorCode::SIGN_CONFIG_NOT_FOND);
            }
            $params['t'] = time();
            $params['appkey'] = $config['app_key'];
            // 生成随机数防止重放攻击
            $params['nonce'] = app(CryptoService::class)->createRandomStr();
            // 签名
            $params['sign'] = (new SignService)->makeSignature($params,$signType);
        }catch (\Exception $e) {
            Log::error($e->getMessage().$e->getTraceAsString());

            throw new SignException(ErrorCode::SIGN_COMPONENT_ERROR);
        }
        return $params;
    }

    /**
     * 构建签名
     * @param  array  $params
     *  必填参数:
     *      timestamp: 时间戳
     *      nonce: 随机数
     *      请求的其它参数...
     * @param string $signType
     *  签名类型
     * @return false|string
     * @throws SignException
     */
    public function makeSignature($params = array(),string $signType = 'kabel')
    {
        try {
            if (!is_array($params)) {
                throw new SignException(ErrorCode::PARAMS_ERROR);
            }
            //获取appSecret
            $config = config("kabel_sign.$signType");
            //获取sign
            $signData = $this->loopArraySign($params, 3986);
            if (!$config['secret']) {
                return false;
            }
            return strtoupper(md5($signData.$config['secret']));
        }catch (\Exception $e) {
            Log::error($e->getMessage().$e->getTraceAsString());
            throw new SignException(ErrorCode::SIGN_COMPONENT_ERROR);
        }
    }

    /**
     * 递归生成参数
     * @param  array  $params
     * @param  int  $rfc
     * @return string
     */
    public function loopArraySign($params = array(), $rfc = 3986)
    {
        $sign = "";
        ksort($params);
        foreach ($params as $k => $v) {
            if (empty($v)) {
                continue;
            }
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

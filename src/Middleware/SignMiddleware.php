<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 12:02,
 * @LastEditTime: 2022/1/18 12:02,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Middleware;


use Kabel\Sign\Constants\ErrorCode;
use Kabel\Sign\Exceptions\CustomException;
use Kabel\Sign\Services\SignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SignMiddleware
{
    /**
     * @param  Request  $request
     * @param  \Closure  $next
     * @param  string  $signType
     * @return mixed
     * @throws CustomException
     */
    public function handle(Request $request, \Closure $next,$signType = 'kabel')
    {
        $param = request()->toArray();
        // 是否校验签名
        if (config("kabel_sign.$signType.is_open")) {
            $timestamp = $param['t'] ?? '';
            $sign = $param['sign'] ?? '';
            $appkey = $param['appkey'] ?? '';
            $nonce = $param['nonce'] ?? '';
            if (empty($nonce)) {
                throw new CustomException(ErrorCode::NONCE_NOT_FOUND);
            }
            // 校验密钥是否已使用
            $cacheKey = $this->getCacheKey($nonce);
            $isPass = Cache::get($cacheKey);
            if (!empty($isPass)) {
                throw new CustomException(ErrorCode::NONCE_ERROR);
            }
            // 将随机值设置60秒过期,防止频繁用同一个随机值发起请求
            Cache::put($cacheKey, 1, 60);
            if (empty($timestamp)) {
                throw new CustomException(ErrorCode::TIMESTAME_ERROR);
            }
            if (empty($appkey)) {
                throw new CustomException(ErrorCode::APP_KEY_ERROR);
            }
            // 没有签名
            if (empty($sign)) {
                throw new CustomException(ErrorCode::SIGN_NOT_FOUND);
            }
            // 签名时效检验
            if ((time() - $timestamp) > config("kabel_sign.$signType.timeout")) {
                throw new CustomException(ErrorCode::SIGN_TIMEOUT);
            }
            // 去掉签名
            unset($param['sign']);
            $newSign = app(SignService::class)->makeSignature($param,$signType);
            // appkey是否匹配并且签名匹配
            if (config("kabel_sign.$signType.appkey") == $appkey && $newSign != $sign) {
                throw new CustomException(ErrorCode::SIGN_ERROR);
            }
            // 去掉没有用的参数
            $request->offsetUnset('t');
            $request->offsetUnset('sign');
            $request->offsetUnset('appkey');
            $request->offsetUnset('nonce');
        }

        return $next($request);
    }

    /**
     * 获取缓存key
     * @param string $nonce 随机值
     * @return string
     */
    protected function getCacheKey(string $nonce): string
    {
        return "sign_nonce:" . $nonce;
    }
}

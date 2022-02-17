<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/19 10:25,
 * @LastEditTime: 2022/1/19 10:25,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Middleware;


use Kabel\Sign\Constants\ErrorCode;
use Kabel\Sign\Exceptions\SignException;
use Kabel\Sign\Library\Aes;
use Kabel\Sign\Library\Rsa;
use Illuminate\Http\Request;

/**
 * 加密数据
 * Class EncryptionMiddleware
 * @package App\Sign\Middleware
 */
class CryptoMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @throws SignException
     */
    public function handle(Request $request, \Closure $next)
    {
        // 数据不为空的时候才解密
        if (count($request->input()) > 0) {
            // 用随机数解密数据
            $rsa = config('kabel_sign.rsa.kabel');
            $rsaModel = new Rsa($rsa['public_key'],$rsa['private_key']);
            // 用私钥解密key得到密钥
            $clientPrivateKey = $request->input('private_key','');
            $secret = $rsaModel->privateDecrypt($clientPrivateKey);
            // 获取加密的数据
            $encrypted = $request->input('encrypted_data','');
            if(!is_string($encrypted)) {
                throw new SignException(ErrorCode::DATA_ERROR);
            }
            $iv =  $request->input('iv','');
            // 解密密文
            $result = (new Aes($secret,$iv))->decrypt($encrypted);
            if (empty($result)) {
                throw new SignException(ErrorCode::CRYPTO_ERROR);
            }
            // 去掉没有用的参数
            $request->offsetUnset('encrypted_data');
            $request->offsetUnset('private_key');
            $request->offsetUnset('iv');
        }
        return $next($request->merge($result ?? []));
    }
}

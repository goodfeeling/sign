<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/19 21:16,
 * @LastEditTime: 2022/1/19 21:16,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Services;


use Kabel\Sign\Interfaces\CryptoServiceInterface;
use Kabel\Sign\Library\Aes;
use Kabel\Sign\Library\Rsa;

class CryptoService implements CryptoServiceInterface
{
    /**
     * 生成加密数据
     * @param  array  $data  需要加密的数据
     *
     * @return array [
     *          private_key,// 加密的密码
     *          encrypted_data// 加密的数据
     * ]
     */
    public function generatorEncryptedData(array $data)
    {
        $config = config('kabel_sign.rsa.kabel');
        // 生成16位密钥
        $key = $this->createRandomStr();
        // 生成实例
        $rsaModel = new Rsa($config['public_key'], $config['private_key']);
        // 加密密钥
        $secret = $rsaModel->publicEncrypt($key);
        // 生成随机数
        $iv = $this->createRandomStr();
        return [
            // 生成对称加密的数据
            'encrypted_data' => (new Aes($key, $iv))->encrypt($data),
            // 非对称加密的密钥
            'private_key' => $secret,
            // 随机数
            'iv' => $iv
        ];
    }

    /**
     * 随机生成16位字符串
     * @return string 生成的字符串
     */
    public function createRandomStr()
    {
        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

}

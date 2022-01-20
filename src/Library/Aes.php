<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 14:03,
 * @LastEditTime: 2022/1/18 14:03,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Library;


use Illuminate\Support\Facades\Log;

/**
 * 对称加密
 * Class AesLib
 * @package App\Sign\Library
 */
class Aes
{
    /**
     * var string $method 加解密方法
     */
    protected string $method;

    /**
     * var string $secret_key 加解密的密钥
     */
    protected string $secret_key;

    /**
     * var string $iv 加解密的向量（伪随机数）
     */
    protected string $iv;

    /**
     * var int $options
     */
    protected int $options;

    /**
     * 构造函数
     * @param string $key     密钥
     * @param string $method  加密方式
     * @param string $iv      向量
     * @param int    $options
     */
    public function __construct($key = '',$iv = '', $method = 'AES-128-CBC',  $options = OPENSSL_RAW_DATA)
    {
        $this->secret_key = isset($key) ? $key : 'CWq3g0hgl7Ao2OKI';
        $this->method = in_array($method, openssl_get_cipher_methods()) ? $method : 'AES-128-CBC';
        $this->iv = $iv;
        $this->options = in_array($options, [OPENSSL_RAW_DATA, OPENSSL_ZERO_PADDING]) ? $options : OPENSSL_RAW_DATA;
    }

    /**
     * 加密
     * @param string $data 加密的数据
     * @return string
     */
    public function encrypt($data = '')
    {
        if (empty($data)) {
            throw new \RuntimeException('加密数据不能为空');
        }
        try {
            $base64_str = base64_encode(json_encode($data));
            $data = base64_encode(openssl_encrypt($base64_str, $this->method, $this->secret_key, $this->options, $this->iv));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $data;
    }

    /**
     * 解密
     * @param string $data 解密的数据
     * @return array
     */
    public function decrypt($data = '')
    {
        if (empty($data)) {
            throw new \RuntimeException('解密数据不能为空');
        }
        $encrypted = base64_decode($data);
        $decrypted = openssl_decrypt($encrypted, $this->method, $this->secret_key, $this->options, $this->iv);
        return json_decode(base64_decode($decrypted), true);
    }
}

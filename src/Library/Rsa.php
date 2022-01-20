<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 14:02,
 * @LastEditTime: 2022/1/18 14:02,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Library;


/**
 * 非对称加密
 * Class RsaLib
 * @package App\Sign\Library
 */
class Rsa
{
    /**
     * 私钥
     * @var string
     */
    private string $PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA06OI+vl+xIXlKC3jXtIX7asCaEX4l3BmNxLxYWmUD783KG1j
1vslIDV+vIwCEef/mP9b169nVJ5ybz8MyrmZXQGBLVWhiHHNrMiBdJwA321zXucr
blEAlvY0kmctIAMMnqalzGLApz7/RVNbHJA/ES/5fL6f7QISPV65swrGvxfmmdrx
7zrUtwv90G4uK8YIsSx4dcn1tUsvNfH+AdcjOIVpoFATRg8sQKXLmlS1R80uqGmf
fZlqEsy/HxY2fJJvnfqoh6zFkzA2Vx8XULYfj6Ppn5Kax0fX6KB5+kBajnKgLC2z
jz+ejpTYecMzV+4hq8NFwFUwRIUNkqbttO9EZQIDAQABAoIBAQCobkTs4DTYOGtY
n7SNWQy8FFYVIGKoO0bN2+CIkxrHsXk3Tl+fzz4LtSdI7PAUyhsr60Zvj+Pffz45
dOc8S5tXXoQszTKCQXfbY7NLV4CGUDf6NmXlJMggXI8YWM6b5HFdrejTkWAbelJ0
HNOtFstqZVDby2XBnN1hRArsB86Gcw93inTGrB+ma9DtbdWSQtrMcoNXZwxr2Q5X
onzB+GXBjtFkm1oMdjX2pplI6dnJD6rIs1/G9ht/4GkOvTgPxoc9G9lXqCOcQYgR
3ypC9VCtXN6MW3geddabRKM7zc2VOc5qbgQyloo5MdkLSmO0P8BlwD9cBid+oNbh
8ceK+a9BAoGBAO4aNY79dVh0i3mAn/8hYKWb2m9+NTMJnJdFWevOHwbOfktCbImT
XX0jpKBtgDEaMCFycm9N56OI7Sjhh8HqzV7m5p/XRqAS0K+CDzVzXVLGbXh8hZQV
Tn4OW63jdEiu4cqO5URqRRIXbwWx/UWfm7kIYlQTQdKoTFcoo1Ys2mPRAoGBAOOM
Fr7+RfPaCYs7LpyDkGmcGsYkP83kNAJDlq4dkUS0zqT6gfah//Q1IDp5/0JHxHIv
xAMryHqX2kB+EbpJTSbN2ORilgZ1rqkyqpC8Ra8fPzBbS2XgYb6Qi6Z+mgm9fF5m
xk2oR+JWMX+6IEZhMDMuDa4ItxfAh/u6xrKbUiBVAoGAVwb5YIQ/qc8fU4+x6zy1
6JIoquvEYh03QQs2LLwwFvrOqo9iwH4+g4jNmV2sp0XdJbyBGzGsYtefZ3vXdQdv
fSqETRQQWl3GLQAqsuyxxZmFVa6d3FxVTjnNRKeITzCskq7cGb+F83DhQYGnAxWt
g1oPJo/LVUXycUEHQm4ufKECgYBA9VwE+CfWHld9JM8ApVpTm9nU2MJSL6RdRRg9
6njvCUK4vD7fvo2IFKZ3qx4guMYu5s3pLdWUkccfhB3hdU2OF1OklzRG8c+Dw9AH
c4fdH2l1j4ptsemVckQ7qoak4zAe7u4Le0/SIFMPKH5QOSx+X9ZN6XUDVdY8Gazh
jg+a5QKBgQCa08io6ggPiJIoFfKvixGCAk7kDzA2EXFgT4KNPXR8KA8sH4w/9CHK
iwVSe52kjihHMEfnsJwcg+8+HtMZhWHciAEM/Ymbo71G0RIIrdcTplRMVSL7Zhak
WV+Fih91zsUOQyuYNK1uUl1QsPc2QBJZ8cb33CRpo9WseNGXCKyDXw==
-----END RSA PRIVATE KEY-----';

    /**
     * 公钥
     * @var string
     */
    private string $PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA06OI+vl+xIXlKC3jXtIX
7asCaEX4l3BmNxLxYWmUD783KG1j1vslIDV+vIwCEef/mP9b169nVJ5ybz8MyrmZ
XQGBLVWhiHHNrMiBdJwA321zXucrblEAlvY0kmctIAMMnqalzGLApz7/RVNbHJA/
ES/5fL6f7QISPV65swrGvxfmmdrx7zrUtwv90G4uK8YIsSx4dcn1tUsvNfH+Adcj
OIVpoFATRg8sQKXLmlS1R80uqGmffZlqEsy/HxY2fJJvnfqoh6zFkzA2Vx8XULYf
j6Ppn5Kax0fX6KB5+kBajnKgLC2zjz+ejpTYecMzV+4hq8NFwFUwRIUNkqbttO9E
ZQIDAQAB
-----END PUBLIC KEY-----';

    /**
     * Rsa constructor.
     * @param  string  $privateKey
     * @param  string  $publicKey
     */
    public function __construct()
    {
//        $pubPem = chunk_split($publicKey, 64, "\n");
//        $priPem = chunk_split($privateKey, 64, "\n");
//        $this->PUBLIC_KEY =  "-----BEGIN PUBLIC KEY-----\n".$pubPem."-----END PUBLIC KEY-----\n";
//        $this->PRIVATE_KEY =  "-----BEGIN RSA PRIVATE KEY-----\n".$priPem."-----END RSA PRIVATE KEY-----\n";
    }


    /**
     * 获取私钥
     * @return bool|resource
     */
    private function getPrivateKey()
    {
        $privateKey = $this->PRIVATE_KEY;
        return openssl_pkey_get_private($privateKey);
    }

    /**
     * 获取公钥
     * @return bool|resource
     */
    private function getPublicKey()
    {
        $publicKey = $this->PUBLIC_KEY;
        return openssl_pkey_get_public($publicKey);
    }

    /**
     * 私钥加密
     * @param  string  $data
     * @return null|string
     */
    public function privateEncrypt(string $data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 公钥加密
     * @param  string  $data
     * @return null|string
     */
    public function publicEncrypt(string $data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     * @param  string  $encrypted
     * @return null
     */
    public function privateDecrypt(string $encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 公钥解密
     * @param  string  $encrypted
     * @return null
     */
    public function publicDecrypt(string $encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }

    /**
     * 创建签名
     * @param  string  $data  数据
     * @return null|string
     */
    public function createSign(string $data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_sign($data, $sign, self::getPrivateKey(), OPENSSL_ALGO_SHA256) ? base64_encode($sign) : null;
    }

    /**
     * 验证签名
     * @param  string  $data  数据
     * @param  string  $sign  签名
     * @return bool
     */
    public function verifySign(string $data = '', string $sign = '')
    {
        if (!is_string($data) || !is_string($sign)) {
            return false;
        }
        return (bool) openssl_verify($data, base64_decode($sign), self::getPublicKey(), OPENSSL_ALGO_SHA256);
    }
}

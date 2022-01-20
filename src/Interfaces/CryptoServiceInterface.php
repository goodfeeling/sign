<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/19 21:16,
 * @LastEditTime: 2022/1/19 21:16,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Interfaces;


interface CryptoServiceInterface
{
    /**
     * 生成加密数据
     * @param array  $data 需要加密的数据
     *
     * @return array [
     *          private_key,// 加密的密码
     *          encrypted_data// 加密的数据
     * ]
     */
    public function generatorEncryptedData(array $data);
}

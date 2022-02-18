<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 11:46,
 * @LastEditTime: 2022/1/18 11:46,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Exceptions;


class SignException extends \Exception
{
    public bool $showOriMsg = true; // 是否显示原始异常信息

    public function __construct(array $errInfo)
    {
        parent::__construct($errInfo[0] ?? '', $errInfo[1] ?? '', $errInfo[2] ?? null);
    }
}

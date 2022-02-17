<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2021/12/30 17:23,
 * @LastEditTime: 2021/12/30 17:23,
 * @Copyright: 2021 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign\Enums;



class ClientEnum
{
    // 客户端枚举
    const ACCOUNT = 'account';
    const MANAGER = 'manager';
    const MASTER = 'master';
    const FRAMEWORK = 'framework';
    /**
     * @param  int  $enumType
     * @return array
     */
    protected static function getEnumMap(int $enumType): array
    {
        // TODO: Implement getEnumMap() method.
    }
}

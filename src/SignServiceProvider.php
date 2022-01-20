<?php
/**
 * @Author: yaozhiwen <929089994@qq.com>,
 * @Date: 2022/1/18 11:50,
 * @LastEditTime: 2022/1/18 11:50,
 * @Copyright: 2022 Kabel Inc. 保留所有权利。
 */


namespace Kabel\Sign;


use Kabel\Sign\Interfaces\SignServiceInterface;
use Kabel\Sign\Services\SignService;
use Illuminate\Support\ServiceProvider;

class SignServiceProvider extends ServiceProvider
{
    protected array $command = [

    ];

    /**
     * 服务列表
     * @var array|string[]
     */
    protected array $serviceList = [
        SignServiceInterface::class => SignService::class,// 签名服务
//        CryptoServiceInterface::class => CryptoService::class,// 加密服务
    ];

    // 迁移文件注册命令
    protected array $migrateRegisterCommands = [
    ];

    public function register()
    {
        // 发布模板文件
        $this->registerPublishing();
        // 加载配置文件
        $this->_loadConfig();
        // 服务注册
        foreach ($this->serviceList as $interface => $service) {
            $this->app->instance($interface, $this->app->make($service));
        }
    }

    /**
     * 加载配置文件
     *
     * @Date: 2021/12/29 14:48
     * @Author: ikaijian
     */
    private function _loadConfig()
    {
        // 微信默认配置
        $this->mergeConfigFrom($this->_getConfigPath() . 'kabel_sign.php', 'kabel_sign');
    }
    /**
     * 获取配置文件路径
     *
     * @return string
     * @Date: 2021/12/29 14:48
     * @Author: ikaijian
     */
    private function _getConfigPath(): string
    {
        return __DIR__.'/Config/';
    }


    /**
     * 发布模板文件
     * @author lwz
     */
    protected function registerPublishing()
    {
        // 只有在 console 模式才执行
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Config/kabel_sign.php' => $this->app->basePath('Config').'/kabel_sign.php',
            ]);
        }
    }

}

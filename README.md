## 安装
1.  下载组件包  
```
composer require yzw/kabel-sign
```
2.  发布配置文件
```
php artisan vendor:publish --provider="Kabel\Sign\SignServiceProvider"
kabel_sign.php: sign配置文件
```
3. 配置.env文件

##  后端使用
1.在项目根目录/Kabel/Kernel/HttpKernel.php中绑定 \Kabel\Sign\Middleware\SignServiceProvider::class 中间件
```php
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Kabel\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Kabel\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // 验证签名
        'verify.sign' => \Kabel\Sign\Middleware\SignMiddleware::class,
    ];
```

2.路由绑定中间件
```php
    Route::middleware('verify.sign')->group(function () {
        //需要登录的路由组
    });
```

3.请求外部项目的接口时引入Kabel\Sign\Services\SignService
```php
    use Kabel\Sign\Services\SignService;
    use Kabel\Interfaces\RpcRequestInterface;
    class test
    {
    
        /**
         * RPC请求类
         * @var RpcRequestInterface
         */
        protected RpcRequestInterface $request;
    
        public function __construct(RpcRequestInterface $request)
        {
            $this->request = $request;
        }
        
        public function test()
        {
           // 发送请求
           $params = ["user_id":1001,"company_id":2];
           $this->request->setApiName($apiName)->uploadFile($apiUri, $fileParams, SignService::setParams($params));       
        }
    }
```

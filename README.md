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

## 前端使用
>> POST请求下使用
```html
<!doctype html>
<html>

<head>
    <title>JavaScript Crypto Encryption</title>
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <script type="text/javascript">
        // 签名算法
        function loopArraySign(params) {
            let sign = '';
            let keys = Object.keys(params);
            keys.sort();
            keys.forEach(function(key) {
                if (Array.isArray(params[key])) {
                    sign+= key;
                    sign+= loopArraySign(params[key]);
                }
                else {
                    sign += key+params[key];
                }
            })
            return sign;
        }

        // 生成随机数
        function createRandomStr()
        {
            let str = "";
            let str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            let max = str_pol.length - 1;
            for (let i = 0; i < 16; i++) {
                str += str_pol[Math.floor(Math.random()*Math.floor(max))];
            }
            return str;
        }
        // secret
        let secret = '123'; // 密钥
        let sendData = {
            t:Date.parse(new Date())/1000,// 获取时间时间戳
            nonce:createRandomStr(),// 生成随机数
            appkey:"appkey",// appkey
        };
        console.log(loopArraySign(sendData))
        sendData.sign = md5(loopArraySign(sendData)+secret).toUpperCase();// 签名
        $.post("xxxx",sendData,
            function (data, status) {
                alert("数据: \n" + data + "\n状态: " + status);
            });

    </script>
</head>

<body>

</body>

</html>

```
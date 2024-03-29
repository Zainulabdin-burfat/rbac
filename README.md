<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h1>Laravel - Role Based Access Control</h1>

<h5>Custom Route Wise Access Control</h5>
<h5>This package allows you to manage user permissions and roles in a database and Authentication and Authorization</h5>
<ol type="i">
    <li>Custom RBAC user based roles and permissions package</li>
    <li>Custom RBAC provides flexibility to use Laravel/Passport in a manner of minutes.</li>
</ol>

<h5>Prerequisites</h5>
<li>Laravel ^8.0</li>
<li>Php ^7.3</li>
<li>Laravel/Passport ^10.4</li>

<h5>Commands</h5>

```console
composer require zainburfat/rbac
```

<h5>Run migrations:</h5>

```console
php artisan migrate
```

<h5>Install Passport:</h5>

```console
php artisan passport:install
```

<h5>Use trait in the "User" model:</h5>

```php
use HasApiTokens

use UserPermissionTrait
```

<h5>To exclude some methods/class from creating permissions of them just add "@exclude-permission" in the docs block of class/method you want to exclude.</h5>

```php
/**
 *...
 *@exclude-permission
 *...
 */
class SomeController extends Controller
{
    /**
     *...
     *@exclude-permission
     *...
     */
    public function index()
    {
        ...
    }
}
```

<h5>Permissions are created dynamically through command according to the controllers having methods:</h5>

```console
php artisan create:permission
```

<h5>Define an api authentication guard and set the driver option to passport in config/auth.php:</h5>

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
 
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

<h5>Publish config file</h5>

```php
php artisan vendor:publish --tag=custom-rbac
```

<h5>Set token expirations inside config\customrbac.php:</h5>

```php
    'tokensExpireIn' => now()->addDays(15),
    'refreshTokensExpireIn' => now()->addDays(30),
    'personalAccessTokensExpireIn' => now()->addMonths(6)
```

<h5>Use PermissionsApi middleware to authorize user to specific Api route and for web routes use PermissionsWeb middleware</h5>
<p>app/http/kernel.php under protected $routeMiddleware:</p>

```php
'permissionsApi' => \Zainburfat\Rbac\Middleware\PermissionsApi::class,
'permissionsWeb' => \Zainburfat\Rbac\Middleware\PermissionsWeb::class,
```

<h5>Login and register using package's route</h5>
<p>For Login use paramenters ('email', 'passport')</p>
<p>For Register use paramenters ('name', 'email', 'passport')</p>

```php
http://yourdomain/rbac_login
http://yourdomain/rbac_register
```

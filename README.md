<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</h4>

<h1>Laravel - Role Based Access Control</h1>

<h4>Custom Route Wise Access Control</h4>
<h4>This package allows you to manage user permissions and roles in a database and Authentication and Authorization</h4>
<ol type="1">
    <li>Custom RBAC user based roles and permissions package</li>
    <li>Custom RBAC provides flexibility to use Laravel/Passport in a manner of minutes.</li>
</ol>

<h4>Prerequisites</h4>
<li>Laravel ^8.0</li>
<li>Php ^7.3</li>
<li>Laravel/Passport ^10.4</li>

<h4>Commands</h4>

```console
composer require zainburfat/rbac
```

<h4>Run migrations:</h4>

```console
php artisan migrate
```

<h4>Install Passport:</h4>

```console
php artisan passport:install
```

<h4>Use trait in the "User" model:</h4>

```php
use HasApiTokens

use UserPermissionTrait
```

<h4>Permissions are created dynamically through command according to the controllers having methods:</h4>

```console
php artisan create:permission
```

<h4>Define an api authentication guard and set the driver option to passport in config/auth.php:</h4>

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

<h4>Set token expirations inside App\Providers\AuthServiceProvider:</h4>

```php
Passport::tokensExpireIn(now()->addDays(15));
Passport::refreshTokensExpireIn(now()->addDays(30));
Passport::personalAccessTokensExpireIn(now()->addMonths(6));
```

<h4>For more information about passport goto the <a href="https://laravel.com/docs/9.x/passport" target="_blank">Laravel Passport</a> documentation:</h4>

<br>
<h4>Add route middleware for web routes authorization.</h4>
<h4>app/http/kernel.php under protected $routeMiddleware:</h4>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```

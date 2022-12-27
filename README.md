<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Laravel - Role Based Access Control</h2>

<p>Custom Route Wise Access Control</p>
<p>This package allows you to manage user permissions and roles in a database and Authentication and Authorization</p>
<ol type="1">
    <li>Custom RBAC user based roles and permissions package</li>
    <li>Custom RBAC provides flexibility to use Laravel/Passport in a matter of minutes.</li>
</ol>

<p>Prerequisites</p>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<p>Commands</p>

```php
composer require zainburfat/rbac
```

<p>Run migrations</p>

```php
php artisan migrate
```

<p>Install Passport</p>

```php
php artisan passport:install
```

<p>Use trait in the "User" model</p>

```php
use HasApiTokens

use UserPermissionTrait
```

<p>Permissions are created dynamically through command according to the controllers having methods</p>

```php
php artisan create:permission
```

<p>Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:
</p>

```php
'guards' => [
    'web' => [
        ...
    ],
 
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

<p>By default, Passport issues long-lived access tokens that expire after one year. If you would like to configure a longer / shorter token lifetime, you may use the tokensExpireIn, refreshTokensExpireIn, and personalAccessTokensExpireIn methods. These methods should be called from the boot method of your application's App\Providers\AuthServiceProvider class:
</p>

```php
Passport::tokensExpireIn(now()->addDays(15));
Passport::refreshTokensExpireIn(now()->addDays(30));
Passport::personalAccessTokensExpireIn(now()->addMonths(6));
```

<p>For more information about passport goto the Laravel/Passport
<a href="https://laravel.com/docs/9.x/passport" target="_blank">Laravel Passport</a> documentation</p>

<br>
<br>
<p>Add route middleware for web routes authorization.</p>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```

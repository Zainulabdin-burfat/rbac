<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>
<h4>This package allows you to manage user permissions and roles in a database and Authentication and Authorization</h4>
<ol type="1">
    <li>Custom RBAC user based roles and permissions package</li>
    <li>Custom RBAC provides flexibility to use Laravel/Passport in a matter of minutes.</li>
</ol>

<br>
<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<br>
<h3>Commands</h3>

```bash
composer require zainburfat/rbac
```

<br>
<b>Run migrations</b>

```bash
php artisan migrate
```

<b>Install Passport</b>

```bash
php artisan passport:install
```

<b>Use trait in the "User" model</b>

```php
use HasApiTokens

use UserPermissionTrait
```

<br>
<h3>Permissions are created dynamically through command according to the controllers having methods</h3>

```bash
php artisan create:permission
```

<h3>Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:
</h3>

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

<br>
<h3>By default, Passport issues long-lived access tokens that expire after one year. If you would like to configure a longer / shorter token lifetime, you may use the tokensExpireIn, refreshTokensExpireIn, and personalAccessTokensExpireIn methods. These methods should be called from the boot method of your application's App\Providers\AuthServiceProvider class:
</h3>

```php
Passport::tokensExpireIn(now()->addDays(15));
Passport::refreshTokensExpireIn(now()->addDays(30));
Passport::personalAccessTokensExpireIn(now()->addMonths(6));
```

<br>
<h3>Add route middleware for web routes authorization</h3>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```

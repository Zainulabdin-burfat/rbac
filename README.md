<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>
<h4>This package allows you to manage user permissions and roles in a database and authentication and authorization</h4>
<ol type="1">
    <li>Custom RBAC user based roles and permissions package</li>
    <li>Custom RBAC provides a full token based server implementation for your Laravel application in a matter of minutes.</li>
</ol>

<br>
<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<br>
<h3>Commands</h3>

``` bash
composer require zainburfat/rbac
```

<br>
<b>Run migrations</b>

``` bash
php artisan migrate
```

<b>Use trait in the "User" model</b>

```php
use UserPermissionTrait
```

<br>
<p>Permissions are created dynamically through command according to the controllers having methods</p>

``` bash
php artisan create:permission
```

<br>
<p>Use API driver as token or which ever you are using eg:Passport, Sactum, etc... </p>

```php
'guards' => [
    'web' => [
        ...
    ],

    'api' => [
        'driver' => 'token',
        'provider' => 'users',
        'hash' => true
    ],
],
```

<br>
<h5>Add route middleware for api routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'scope' => \Zainburfat\rbac\Middleware\Scope::class,
```

<br>
<h5>How to protect routes using scope middleware for authorization</h5>

```php
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users', 'UserController@index')->middleware('scope:user.index');
});
```

<br>
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```

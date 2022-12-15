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
    <li>Laravel Passport provides a full OAuth2 server implementation for your Laravel application in a matter of minutes. Passport is built on top of the League OAuth2 server that is maintained by Andy Millington and Simon Hamp.</li>
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
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```


<br>
<h5>Install Passport</h5>

``` bash
php artisan passport:install
```

<br>
<p>Permissions are created dynamically through command according to the controllers having methods</p>

``` bash
php artisan create:permission
```

<br>
<p>Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests.</p>

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
<h5>Add route middleware for api routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
```

<br>
<h5>How to protect routes using scopes auth</h5>

```php
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users', 'UserController@index')->middleware('scope:user.index');
    // for multiple check
    // ->middleware('scopes:user.index, user.create');
});
```

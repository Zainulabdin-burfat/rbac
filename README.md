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
    <li>Custom RBAC provides flexibility to use both Laravel/Sanctum, Laravel/Passport using Adapter pattern.</li>
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

<b>Use trait in the "User" model</b>

```php
use UserPermissionTrait
```

<br>
<p>Permissions are created dynamically through command according to the controllers having methods</p>

```bash
php artisan create:permission
```

<br>
<h5>How to protect routes using scope middleware for authorization</h5>

<br>
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

```php
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,
```

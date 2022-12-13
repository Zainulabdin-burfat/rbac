<p align="center">
<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
<!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>

<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<h3>Commands</h3>
<li>composer require zainburfat/rbac</li>
<li>use Trait in User Model <b> use UserPermissionTrait</b></li>
<li>php artisan migrate</li>
<li>php artisan create:permission</li>
<li></li>

<p>Permissions are created dynamically through command according to the controllers having methods</p>

<br>
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>
<li>'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,</li>

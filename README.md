<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>

<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<h3>Commands</h3>
<li>composer require zainburfat/rbac</li>
<li>php artisan migrate</li>
<li>php artisan create:permission</li>
<li></li>

<p>Permissions are created dynamically through command according to the controllers having methods</p>

<br>
<h5>add middleware</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>
<li>'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,</li>



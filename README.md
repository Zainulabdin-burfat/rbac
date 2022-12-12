<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>

<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<h3>Commands</h3>
<h5>php artisan vendor:publish</h5>
<h5>php artisan migrate</h5>
<h5>php artisan db:seed</h5>
<h5>php artisan create:permission</h5>
<p>Permissions are created dynamically through command according to the controllers having methods</p>


add middleware
app/http/kernel.php under protected $routeMiddleware
'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,

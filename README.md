<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Laravel - Role Based Access Control</h2>

<h3>Custom Route Wise Access Control</h3>
<h4>This package allows you to manage user permissions and roles in a database.authentication and authorization</h4>
<ol type="1">
    <li>Custom RBAC like Spatie permissions package</li>
    <li>Laravel Passport provides a full OAuth2 server implementation for your Laravel application in a matter of minutes. Passport is built on top of the League OAuth2 server that is maintained by Andy Millington and Simon Hamp.</li>
</ol>

<br>
<h3>Prerequisites</h3>
<li>Laravel >= 8</li>
<li>php >= 7.3</li>

<br>
<h3>Commands</h3>

    composer require zainburfat/rbac

<br>
<b>Use trait in the "User" model</b>

    use UserPermissionTrait

<br>
<b>Run migrations</b>

    php artisan migrate

<br>
<b>Add this code to AuthServiceProvider.php under boot() method</b>

    use Laravel\Passport\Passport;
    use Zainburfat\rbac\Models\Permission;

    Passport::routes();
    $all_permissions = Permission::select('name')->get()->pluck('name')->toArray();
    $permissions = [];
    foreach ($all_permissions as $permission) {
        $permissions[$permission] = $permission;
    }
    Passport::tokensCan($permissions);

<br>
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

    'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,




<br>
<h5>Install Passport</h5>

    php artisan passport:install

<br>
<p>Permissions are created dynamically through command according to the controllers having methods</p>

    php artisan create:permission

<br>
<p>After running the passport:install command, add the Laravel\Passport\HasApiTokens trait to your App\Models\User model. This trait will provide a few helper  methods to your model which allow you to inspect the authenticated user's token and scopes. If your model is already using the Laravel\Sanctum\HasApiTokens trait, you may remove that trait.</p>
```php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;
        
    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
    }
```
<br>
<p>Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests.</p>

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

<br>
<h5>Add route middleware for api routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>

    'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
    'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,

<br>
<h5>How to protect routes using scopes auth</h5>

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('/users', 'UserController@index')->middleware('scope:user.index');
    });

<br>
<h5>To check multiple scopes</h5>

    ->middleware('scopes:check-status,place-orders');

<br>
<h5>Login credentials</h5>

    admin@admin.com
    password

<br>
<h5>Login url</h5>

    http://127.0.0.1:8000/signin
    
<br>
<h5>Test after login with token</h5>

    http://127.0.0.1:8000/testusers
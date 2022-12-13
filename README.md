<p align="center">
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/badge/Downloads-demo-green" alt="Total Downloads"></a>
    <!--<a href="https://packagist.org/packages/zainburfat/rbac"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> -->
    <a href="https://packagist.org/packages/zainburfat/rbac"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
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

<br>
<h5>Add route middleware for web routes authorization</h5>
<p>app/http/kernel.php under protected $routeMiddleware</p>
<li>'permissions' => \Zainburfat\rbac\Middleware\Permissions::class,</li>






<!-- Passport Installation -->
<li>php artisan passport:install</li>
<li>php artisan create:permission</li>
<li>
    <p>After running the passport:install command, add the Laravel\Passport\HasApiTokens trait to your App\Models\User model. This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes. If your model is already using the Laravel\Sanctum\HasApiTokens trait, you may remove that trait:</p>
</li>
<li>
    namespace App\Models;
        
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;
        
    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
    }
</li>
<li><p>Finally, in your application's config/auth.php configuration file, you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:</p></li>
<li>
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
</li>


<p>Permissions are created dynamically through command according to the controllers having methods</p>

<br>
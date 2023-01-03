<?php

namespace Zainburfat\Rbac\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Zainburfat\Rbac\Commands\CreateControllerPermission;

class PermissionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateControllerPermission::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // $this->mergeConfigFrom(
        //     __DIR__.'/../config/auth.php', 'auth'
        // );

        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ]);
    }

    public function boot()
    {
        $this->registerBladeDirectives();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }

    public function registerBladeDirectives()
    {
        //Blade directives

        // @permission('Admin') @endpermission
        Blade::directive('permission', function ($permission) {
            return "<?php if(Auth::check() && (Auth::user()->hasPermissionTo($permission) || Auth::user()->hasDirectPermissionTo($permission)) ){ ?>";
        });
        Blade::directive('endpermission', function () {
            return "<?php } ?>";
        });

        // @role('Admin') @endrole
        Blade::directive('role', function ($role) {
            return "<?php if(Auth::check() && Auth::user()->hasRole($role) ){ ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php } ?>";
        });
    }
}

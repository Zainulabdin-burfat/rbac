<?php

namespace Zainburfat\Rbac\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Zainburfat\Rbac\Commands\CreateControllerPermission;
use Zainburfat\Rbac\Models\Permission;

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
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/customrbac.php' => config_path('customrbac.php'),
        ], 'custom-rbac');

        $this->registerBladeDirectives();

        $this->registerPassportServices();
    }

    public function registerPassportServices()
    {
        $permission_all = Permission::all();

        
        $permissions = ['-'];

        if ($permission_all) {
            unset($permissions);
            foreach ($permission_all as $permission) {
                $permissions[$permission['name']] = $permission['name'];
            }
        }

        Passport::tokensCan($permissions);

        Passport::routes();

        Passport::tokensExpireIn(config('customrbac.tokensExpireIn'));
        Passport::refreshTokensExpireIn(config('customrbac.refreshTokensExpireIn'));
        Passport::personalAccessTokensExpireIn(config('customrbac.personalAccessTokensExpireIn'));
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

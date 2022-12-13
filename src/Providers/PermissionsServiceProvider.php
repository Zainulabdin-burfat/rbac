<?php

namespace Zainburfat\rbac\Providers;

use Zainburfat\rbac\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Zainburfat\rbac\Commands\CreateControllerPermission;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateControllerPermission::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->createScopes();

        Passport::tokensExpireIn(now()->addSeconds(20));
        Passport::personalAccessTokensExpireIn(now()->addSeconds(20));
        Passport::refreshTokensExpireIn(now()->addHours(1));

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission->name) || $user->hasDirectPermissionTo($permission->name);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }


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

    public function createScopes()
    {
        Passport::routes();
        $all_permissions = Permission::select('name')->get()->pluck('name')->toArray();
        $permissions = [];
        foreach ($all_permissions as $permission) {
            $permissions[$permission->name] = $permission->name;
        }
        Passport::tokensCan($permissions);
    }
}

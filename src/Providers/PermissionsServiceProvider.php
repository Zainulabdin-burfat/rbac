<?php

namespace Zainburfat\rbac\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Zainburfat\rbac\Commands\CreateControllerPermission;
use Zainburfat\rbac\Models\Permission;
use Illuminate\Support\Facades\Schema;

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
    }

    public function boot()
    {
        // if (Schema::hasTable('permissions')){
        //     $this->createScopes();
        // }

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

    // public function createScopes()
    // {
    //     Passport::routes();
    //     $all_permissions = Permission::select('name')->get()->pluck('name')->toArray();
    //     $permissions = [];
    //     foreach ($all_permissions as $permission) {
    //         $permissions[$permission] = $permission;
    //     }
    //     Passport::tokensCan($permissions);
    //     User::tokensCan($permissions);
    // }
}

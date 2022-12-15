<?php

namespace Zainburfat\rbac\Commands;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Zainburfat\rbac\Models\Permission;
use Zainburfat\rbac\Models\RolePermission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Zainburfat\rbac\Models\Role;
use Zainburfat\rbac\Models\UserRole;

class CreateControllerPermission extends Command
{
    protected $signature = 'create:permission';
    protected $description = 'Create permissions of the controllers.';

    public function __construct()
    {
        parent::__construct();
    }

    public function getControllerMethodNames($controller, $controllerName, $namespace = "App\Http\Controllers")
    {
        $class = new ReflectionClass($namespace . '\\' . $controller);
        $class_methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($class_methods as $method) {
            if ($method->class == $namespace . '\\' . $controller && $method->name != '__contruct') {
                $methods[] = (string) Str::of($controllerName)->append(" " . $method->name)->slug('.');
            }
        }

        return $methods;
    }

    public function handle()
    {
        // Check if UserPermissionTrait has been used in the User model
        if (!method_exists((new User), 'hasDirectPermissionTo')){
            $this->newLine();
            $this->error("Trait not used (UserPermissionTrait) in the User model");
            $this->newLine();
            return 0;
        }

        // Check if migrations has been run and package table exists
        if (!Schema::hasTable('permissions') || !Schema::hasTable('roles')) {
            $this->newLine();
            $this->error("No package tables Found, run migrations may solve this..!");
            $this->newLine();
            return 0;
        }

        $this->newLine(2);

        $files = File::files("app/Http/Controllers");

        if (isset($files[0]) && $files[0]->getBasename() === "Controller.php") {
            unset($files[0]);
        }

        if (!count($files)) {
            $this->error("No Countrollers Found..!");
            return 0;
        }

        $newPermissions = 0;
        $oldPermissions = 0;

        foreach ($files as $controller) {
            $fileName       = $controller->getBasename();
            $filePathName   = $controller->getPathname();
            $controller     = Str::of($filePathName)->afterLast('/')->remove('.php');
            $controllerName = Str::of($filePathName)->afterLast('/')->remove('Controller.php');

            if ($fileName === "Controller.php")
                continue;

            $methods = (array)$this->getControllerMethodNames($controller, $controllerName);

            if (!count($methods))
                $this->warn("No Methods Found In $controllerName");

            foreach ($methods as $method) {
                $permission = Permission::firstOrCreate(["name" => $method]);

                if ($permission->wasRecentlyCreated) {
                    $this->info("$controller permission created ($method)");
                    $newPermissions++;
                } else {
                    $this->warn("$controller permission already exists ($method)");
                    $oldPermissions++;
                }
            }
            $this->newLine();
        } // end foreach

        $this->info("$newPermissions new permissions were created and $oldPermissions permissions already exists.");
        $this->newLine(2);



        // Here we assign all permissions to demo admin role

        $permissions = Permission::get('id')->pluck('id')->toArray();


        $user = DB::table('users')->insertOrIgnore([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $this->info(($user) ? "Admin created" : "Admin already exist");
        $this->newLine();

        $user = DB::table('users')->where('email', 'admin@admin.com')->first('id');

        $role = Role::firstOrCreate(['name' => 'Admin']);
        UserRole::insertOrIgnore(['user_id' => $user->id, 'role_id' => $role->id]);

        $permissionIds = [];
        foreach ($permissions as $permissionId) {
            $permissionIds[] = ['role_id' => $role->id, 'permission_id' => $permissionId];
        }

        if ($permissionIds) {
            $rolePermission = RolePermission::insertOrIgnore($permissionIds);
            if ($rolePermission)
                $this->info("$rolePermission Permissions assigned to Admin");
            else
                $this->warn("Permissions already assigned to Admin");
        } else {
            $this->newLine();
            $this->warn("No Permissions Found..!");
            $this->newLine();
        }

        $this->newLine(2);
        $this->info("Command run successfully..!");
        $this->newLine(2);
        return 1;
    }
}

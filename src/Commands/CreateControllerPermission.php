<?php

namespace Zainburfat\rbac\Commands;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        $controller_methods = get_class_methods($namespace . '\\' . $controller);
        $methods = [];
        foreach ($controller_methods as $method) {
            if ($method === "__construct")
                continue;

            $methods[] = (string) Str::of($controllerName)->append(" " . $method)->slug('.');
        }

        return $methods;
    }

    public function handle()
    {
        $this->newLine(2);

        $files = File::files("app/Http/Controllers");

        if (isset($files[0]) && $files[0]->getBasename() === "Controller.php") {
            unset($files[0]);
        }

        if (!count($files))
            return $this->error("No Countrollers Found..!");

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
        }

        $this->info("$newPermissions new permissions were created and $oldPermissions permissions already exists.");

        $this->newLine(2);

        $permissions = Permission::get('id')->pluck('id')->toArray();

        $permissionIds = [];
        foreach ($permissions as $permissionId) {
            $permissionIds[] = ['role_id' => 1, 'permission_id' => $permissionId];
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
    }
}

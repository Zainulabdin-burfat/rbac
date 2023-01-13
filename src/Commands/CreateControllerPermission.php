<?php

namespace Zainburfat\Rbac\Commands;

use App\Models\User;
use Zainburfat\Rbac\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

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
        if (Str::contains($class->getDocComment(), '@exclude-permission')) {
            return [];
        }

        $class_methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $methods = [];
        foreach ($class_methods as $method) {
            if (Str::contains($method->getDocComment(), '@exclude-permission')) {
                continue;
            }

            if ($method->class == $namespace . '\\' . $controller && $method->name != '__contruct') {
                $methods[] = (string) Str::of($controllerName)->append(" " . $method->name)->slug('.');
            }
        }

        return $methods;
    }

    public function handle()
    {
        // Check if UserPermissionTrait has been used in the User model
        if (!method_exists((new User), 'hasDirectPermissionTo')) {
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

        // Get Controllers path from config directories
        $controllersPath = config('customrbac.controllersPath');
        $files = [];
        foreach ($controllersPath as $controllerPath) {
            if (File::isDirectory($controllerPath)) {
                $files[] = File::allFiles($controllerPath);
            }
        }

        $files = call_user_func_array('array_merge', $files);

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
        $this->info("Command run successfully..!");
        $this->newLine(2);
        return 1;
    }
}

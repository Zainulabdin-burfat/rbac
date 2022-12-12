<?php

namespace Zainburfat\rbac\database\seeders;

use Zainburfat\rbac\Models\Role;
use Zainburfat\rbac\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        dd($user);

        Role::insert(['name' => 'Admin']);
        UserRole::insert(['user_id' => $user->id, 'role_id' => 1]);
    }
}

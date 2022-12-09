<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['remember_token', 'email_verified_at', 'password'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasPermissionTo($permission)
    {
        foreach ($this->roles as $role) {
            $permissions = $role->permissions->pluck('name')->toArray();
            if (in_array($permission, $permissions))
                return true;
        }

        return false;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    public function hasDirectPermissionTo($permission)
    {
        foreach ($this->permissions->toArray() as $permissionName) {
            if ($permission == $permissionName['name'])
                return true;
        }

        return false;
    }

    public function hasRole($role)
    {
        foreach ($this->roles->toArray() as $roleName) {
            if (strtolower($roleName['name']) == strtolower($role))
                return true;
        }
        return false;
    }

    public function getRoleNames()
    {
        return $this->roles->pluck('name')->toArray();
    }

    public function getDirectPermissions()
    {
        return $this->permissions->pluck('name')->toArray();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function formatIndex()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "roles" => $this->roles->pluck('name', 'id')->toArray(),
        ];
    }
}

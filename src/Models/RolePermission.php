<?php

namespace Zainburfat\Rbac\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'permission_role';

    protected $fillable = ['permission_id', 'role_id'];
}

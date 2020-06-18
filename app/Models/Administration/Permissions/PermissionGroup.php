<?php

namespace App\Models\Administration\Permissions;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends Model
{
    public $table = 'permissions_group';

    public $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id');
    }
}

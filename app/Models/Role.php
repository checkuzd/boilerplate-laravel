<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;

    public function access_to(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_access', 'access_main_id', 'access_child_id');
    }
}

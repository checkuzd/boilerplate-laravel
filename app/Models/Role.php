<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function accessed_by(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_access', 'access_child_id', 'access_main_id');
    }

    public function scopeCurrentUserCanManageRoles(Builder $query): void
    {
        $query->with(['access_to' => function ($query) {
            $query->where('id', '!=', auth()->user()->getRoleId())
                ->orderBy('access_child_id', 'asc');
        }])->where('id', auth()->user()->getRoleId());
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Menu\MenuItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'permission_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'permission_id');
    }

    public function menu_items(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_permission', 'permission_id', 'menu_item_id');
    }
}

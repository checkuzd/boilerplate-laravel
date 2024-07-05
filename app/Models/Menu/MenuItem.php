<?php

declare(strict_types=1);

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'menu_item_id')->with('children')->orderBy('order', 'ASC');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}

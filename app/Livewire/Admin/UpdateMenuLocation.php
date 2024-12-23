<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Menu\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Component;

class UpdateMenuLocation extends Component
{
    #[Locked]
    public int $menu_id;

    public array $location;

    public function mount($menu_id): void
    {
        $this->menu_id = $menu_id;
        $menuLocation = Menu::select('location')->find($menu_id)->toArray();
        $this->location = (! is_null($menuLocation['location']) || $menuLocation['location']) ? explode(',', $menuLocation['location']) : [];
    }

    public function updateLocation(): void
    {
        $menuLocation = ($this->location) ? implode(',', $this->location) : '';

        Menu::where('location', $menuLocation)->update([
            'location' => null,
        ]);

        Menu::where('id', $this->menu_id)->update([
            'location' => $menuLocation,
        ]);

        Cache::forget('menu-settings');
        Cache::forget('menu-view-'.auth()->user()->getRoleId());

        $this->toast('Menu location updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.update-menu-location');
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Menu\Menu;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UpdateMenuName extends Component
{
    #[Locked]
    public $id;

    #[Rule('required', as: 'menu name')]
    public $name;

    protected $rules = [
        'name' => 'required',
    ];

    public function mount($id, $name): void
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function update(): void
    {
        $this->validate();

        Menu::where('id', $this->id)
            ->update(['name' => $this->name]);

        $this->toast('Menu Name updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.update-menu-name');
    }
}

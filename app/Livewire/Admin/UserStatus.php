<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class UserStatus extends Component
{
    public $user_id;

    public $status;

    public function mount($user_id, $status): void
    {
        $this->user_id = $user_id;
        $this->status = $status;
    }

    public function updateStatus(): void
    {
        User::where('id', $this->user_id)
            ->update(['status' => ! $this->status]);

        $this->status = ! $this->status;

        $this->toast('User status updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.user-status');
    }
}

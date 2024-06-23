<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AvatarUploadAndPreview extends Component
{
    use WithFileUploads;

    public $avatar;
    public $avatarThumb;

    public function mount($avatarThumb = null)
    {
        $this->avatarThumb = $avatarThumb;
    }

    public function remove()
    {
        $this->avatar = null;
        $this->avatarThumb = null;

        $this->dispatch('uploaded');
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:1024',
        ]);
        $this->avatarThumb = null;

        $this->dispatch('uploaded');
    }

    public function render()
    {
        return view('livewire.avatar-upload-and-preview');
    }
}

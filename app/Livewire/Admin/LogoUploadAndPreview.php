<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class LogoUploadAndPreview extends Component
{
    use WithFileUploads;

    public $logo;

    public function remove()
    {
        $this->logo = null;
    }

    public function upload()
    {
        $this->logo->storeAs('public', 'logo.png');
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'nullable|image|max:1024',
        ]);

        $this->logo->storeAs('public', 'logo.png');

        $this->js(<<<JS
            $('.logo-preview img').attr('src', '{{ SettingsHelper::logo() }}?t=' + new Date().getTime());
        JS);
        // $this->dispatch('logoUpdated');
        $this->toast('Logo updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.logo-upload-and-preview');
    }
}

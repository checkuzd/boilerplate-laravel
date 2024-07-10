<?php

declare(strict_types=1);

namespace App\Services;

class SettingsService
{
    public function storeFile($file, $filename): void
    {        // if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
        $file->storeAs('public', $filename);    // }
    }
}

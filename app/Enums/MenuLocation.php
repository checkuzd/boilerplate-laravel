<?php

namespace App\Enums;

enum MenuLocation: string
{
    case ADMIN = 'admin';
    case FRONT_END = 'front_end';

    public function location(): string
    {
        return match ($this) {
            static::ADMIN => 'admin',
            static::FRONT_END => 'front_end',
        };
    }

    public function displayLocation(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::FRONT_END => 'Front End',
        };
    }
}

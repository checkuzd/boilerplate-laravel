<?php

declare(strict_types=1);

namespace App\Enums;

enum MenuLocation: string
{
    case ADMIN = 'admin';
    case FRONT_END = 'front_end';

    public function location(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::FRONT_END => 'front_end',
        };
    }

    public function displayLocation(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::FRONT_END => 'Front End',
        };
    }
}

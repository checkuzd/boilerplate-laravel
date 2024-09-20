<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case CUSTOMER = 'Customer';
    case MANAGER = 'Manager';
}

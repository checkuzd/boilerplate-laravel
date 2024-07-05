<?php

namespace App\Enums;

enum MenuItemType: string
{
    case CUSTOM_LINKS = 'custom_links';
    case LABEL = 'label';
    case ROUTE_NAME = 'route_name';

    public function type(): string
    {
        return match ($this) {
            self::LABEL => 'label',
            self::CUSTOM_LINKS => 'custom_links',
            self::ROUTE_NAME => 'route_name',
        };
    }

    public function displayType(): string
    {
        return match ($this) {
            self::LABEL => 'Label',
            self::CUSTOM_LINKS => 'Custom Links',
            self::ROUTE_NAME => 'Route Name',
        };
    }
}

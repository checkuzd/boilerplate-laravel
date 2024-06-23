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
            static::LABEL => 'label',
            static::CUSTOM_LINKS => 'custom_links',
            static::ROUTE_NAME => 'route_name',
        };
    }

    public function displayType(): string
    {
        return match ($this) {
            static::LABEL => 'Label',
            static::CUSTOM_LINKS => 'Custom Links',
            static::ROUTE_NAME => 'Route Name',
        };
    }
}

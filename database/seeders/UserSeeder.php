<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\User\AdminSeeder;
use Database\Seeders\User\CustomerSeeder;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}

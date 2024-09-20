<?php

declare(strict_types=1);

namespace Database\Seeders\User;

use App\Enums\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class CustomerSeeder extends Seeder
{
    private int $customerCount = 100;

    private string $customerRole = RoleEnum::CUSTOMER->value;

    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Customer',
            'last_name' => '',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => '12345678',
            'status' => true,
        ]);

        $user->assignRole($this->customerRole);

        $this->command->warn(PHP_EOL.'Creating shop customers...');
        $customers = $this->withProgressBar(
            $this->customerCount,
            fn () => User::factory(1)
                ->withRole($this->customerRole)
                ->create()
        );
        $this->command->info('Shop customers created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}

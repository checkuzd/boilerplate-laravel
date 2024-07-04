<?php

namespace Database\Seeders\User;

use Closure;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class CustomerSeeder extends Seeder
{
    private int $customerCount = 1000;
    private string $userRole = 'customer';

    public function run(): void
    {
        $user = User::create([
                    'first_name' => 'Customer',
                    'last_name' => '',
                    'username' => 'customer',
                    'email' => 'customer@test.com',
                    'password' => Hash::make('12345678'),
                    'status' => true,
                ]);

        $user->assignRole('customer');

        $this->command->warn(PHP_EOL . 'Creating shop customers...');
        $customers = $this->withProgressBar(
            $this->customerCount,
            fn () =>
                User::factory(1)
                ->withRole($this->userRole)
                ->create()
        );
        $this->command->info('Shop customers created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

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

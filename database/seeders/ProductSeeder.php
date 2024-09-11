<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Closure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class ProductSeeder extends Seeder
{
    private int $productCount = 10;

    public function run(): void
    {
        // Product::factory(10)->create();

        $this->command->warn(PHP_EOL.'Creating shop products...');
        $this->withProgressBar(
            $this->productCount,
            fn () => Product::factory(1)
                ->create()
        );
        $this->command->info('Shop products created.');
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

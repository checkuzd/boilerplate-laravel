<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->catchPhrase(),
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(100, 400),
            'old_price' => 500,
            'stock' => $this->faker->numberBetween(100, 1000),
            'stock_alert' => 10,
        ];
    }

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product) {
            $product->addMediaFromUrl('https://picsum.photos/360/720')->toMediaCollection('product-images');
        });
    }
}

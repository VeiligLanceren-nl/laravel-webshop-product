<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;

class ProductVariantFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'product_id' => Product::factory(),
            'sku' => Str::random(),
            'price' => $this->faker->randomFloat(2, 10),
            'stock' => $this->faker->randomNumber(2),
        ];
    }
}
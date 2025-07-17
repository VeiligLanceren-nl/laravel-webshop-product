<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductImage;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ProductImage::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'url' => $this->faker->imageUrl(),
            'alt_text' => $this->faker->words(3, true),
            'is_primary' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 10),
        ];
    }
}
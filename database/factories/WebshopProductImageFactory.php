<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;

/**
 * @extends Factory<WebshopProductImage>
 */
class WebshopProductImageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = WebshopProductImage::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'webshop_product_id' => WebshopProduct::factory(),
            'url' => $this->faker->imageUrl(),
            'alt_text' => $this->faker->words(3, true),
            'is_primary' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 10),
        ];
    }
}
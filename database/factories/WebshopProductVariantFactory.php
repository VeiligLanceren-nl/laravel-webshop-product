<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;

class WebshopProductVariantFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = WebshopProductVariant::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'product_id' => WebshopProduct::factory(),
            'sku' => Str::random(),
            'price' => $this->faker->randomFloat(2, 10),
            'stock' => $this->faker->randomNumber(2),
        ];
    }
}
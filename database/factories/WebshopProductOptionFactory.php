<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductOption;

class WebshopProductOptionFactory extends Factory
{
    protected $model = WebshopProductOption::class;

    public function definition(): array
    {
        return [
            'webshop_product_id' => WebshopProduct::factory(),
            'name' => $this->faker->randomElement(['Printing', 'Photoshoot', 'Gift Wrapping']),
            'additional_price' => $this->faker->randomFloat(2, 5, 100),
            'is_required' => $this->faker->boolean(20), // 20% chance required
            'order' => $this->faker->numberBetween(0, 10),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttribute;

/**
 * @extends Factory<WebshopProductAttribute>
 */
class WebshopProductAttributeFactory extends Factory
{
    protected $model = WebshopProductAttribute::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->word()),
            'is_variation' => $this->faker->boolean(),
        ];
    }
}

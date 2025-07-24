<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;

class WebshopProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = WebshopProduct::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'active' => true,
            'featured' => $this->faker->boolean(),
            'stock' => $this->faker->numberBetween(0, 100),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'dimensions' => [
                'length' => $this->faker->randomFloat(1, 10, 100),
                'width'  => $this->faker->randomFloat(1, 10, 100),
                'height' => $this->faker->randomFloat(1, 10, 100),
            ],
        ];
    }
}

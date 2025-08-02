<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttribute;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttributeValue;

/**
 * @extends Factory<WebshopProductAttributeValue>
 */
class WebshopProductAttributeValueFactory extends Factory
{
    protected $model = WebshopProductAttributeValue::class;

    public function definition(): array
    {
        return [
            'webshop_product_attribute_id' => WebshopProductAttribute::factory(),
            'value' => $this->faker->word(),
        ];
    }
}

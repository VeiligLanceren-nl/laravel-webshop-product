<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\WebshopProductAttributeFactory;

class WebshopProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_variation'];

    public function values(): HasMany
    {
        return $this->hasMany(WebshopProductAttributeValue::class, 'webshop_product_attribute_id');
    }

    /**
     * @return WebshopProductAttributeFactory
     */
    protected static function newFactory(): WebshopProductAttributeFactory
    {
        return WebshopProductAttributeFactory::new();
    }
}

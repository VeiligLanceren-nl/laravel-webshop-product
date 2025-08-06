<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Database\Factories\WebshopProductAttributeValueFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebshopProductAttributeValue extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['webshop_product_attribute_id', 'value'];

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(WebshopProductAttribute::class, 'webshop_product_attribute_id');
    }

    /**
     * @return BelongsToMany
     */
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(
            WebshopProductVariant::class,
            'webshop_product_attribute_value_variant',
            'webshop_product_attribute_value_id',
            'webshop_product_variant_id'
        );
    }

    /**
     * @return HasMany<WebshopProductImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(WebshopProductImage::class, 'webshop_product_attribute_value_id');
    }

    /**
     * @return WebshopProductAttributeValueFactory
     */
    protected static function newFactory(): WebshopProductAttributeValueFactory
    {
        return WebshopProductAttributeValueFactory::new();
    }
}

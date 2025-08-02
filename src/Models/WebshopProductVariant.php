<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\WebshopProductVariantFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WebshopProductVariant extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'price' => 'decimal:2',
        'options' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(WebshopProduct::class, 'webshop_product_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            WebshopProductAttributeValue::class,
            'webshop_product_attribute_value_variant',
            'webshop_product_variant_id',
            'webshop_product_attribute_value_id'
        );
    }


    /**
     * @return WebshopProductVariantFactory
     */
    protected static function newFactory(): WebshopProductVariantFactory
    {
        return WebshopProductVariantFactory::new();
    }
}

<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\WebshopProductImageFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class WebshopProductImage extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'url',
        'order',
        'alt_text',
        'is_primary',
        'webshop_product_id',
        'webshop_product_attribute_value_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_primary' => 'boolean',
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
     * @return BelongsTo
     */
    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(WebshopProductAttributeValue::class, 'webshop_product_attribute_value_id');
    }

    /**
     * @return string
     */
    public function getImageAttribute(): string
    {
        if (!$this->getAttribute('url')) {
            return asset(config('webshop-product.images.placeholder'));
        }

        if (preg_match('/^https?:\/\//', $this->getAttribute('url'))) {
            return $this->getAttribute('url');
        }

        $disk = config('webshop-product.images.disk', 'public');

        if (Storage::disk($disk)->exists($this->getAttribute('url'))) {
            return Storage::disk($disk)
                ->url($this->getAttribute('url'));
        }

        $prefix = config('webshop-product.images.storage_prefix', '/storage/');

        return (config('webshop-product.images.use_full_url', true))
            ? asset($prefix . ltrim($this->getAttribute('url'), '/'))
            : $prefix . ltrim($this->getAttribute('url'), '/');
    }

    /**
     * @return WebshopProductImageFactory
     */
    protected static function newFactory(): WebshopProductImageFactory
    {
        return WebshopProductImageFactory::new();
    }
}

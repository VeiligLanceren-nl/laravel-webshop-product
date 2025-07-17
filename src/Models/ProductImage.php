<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProductImageFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
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
        'product_id',
        'url',
        'alt_text',
        'is_primary',
        'order',
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
        return $this->belongsTo(Product::class);
    }

    /**
     * @return ProductImageFactory
     */
    protected static function newFactory(): ProductImageFactory
    {
        return ProductImageFactory::new();
    }
}

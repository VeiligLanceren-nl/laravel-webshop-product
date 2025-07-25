<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\WebshopProductImageFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'webshop_product_id',
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
        return $this->belongsTo(WebshopProduct::class, 'webshop_product_id', 'id');
    }

    /**
     * @return WebshopProductImageFactory
     */
    protected static function newFactory(): WebshopProductImageFactory
    {
        return WebshopProductImageFactory::new();
    }
}

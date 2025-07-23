<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Database\Factories\WebshopProductVariantFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(WebshopProduct::class);
    }

    /**
     * @return WebshopProductVariantFactory
     */
    protected static function newFactory(): WebshopProductVariantFactory
    {
        return WebshopProductVariantFactory::new();
    }
}

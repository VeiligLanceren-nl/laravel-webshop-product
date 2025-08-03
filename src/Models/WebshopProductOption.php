<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\WebshopProductOptionFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebshopProductOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'webshop_product_id',
        'name',
        'additional_price',
        'is_required',
        'order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(WebshopProduct::class, 'webshop_product_id');
    }

    /**
     * @return WebshopProductOptionFactory
     */
    protected static function newFactory()
    {
        return WebshopProductOptionFactory::new();
    }
}

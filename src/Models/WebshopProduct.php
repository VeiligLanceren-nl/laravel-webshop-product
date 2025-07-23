<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\WebshopProductFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use VeiligLanceren\LaravelWebshopProduct\Facades\SlugConfig;
use VeiligLanceren\LaravelMorphCategories\Support\Traits\HasCategory;

class WebshopProduct extends Model
{
    use SoftDeletes, HasSlug, HasFactory, HasCategory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'sku',
        'name',
        'slug',
        'description',
        'price',
        'active',
        'stock',
        'weight',
        'dimensions',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'active' => 'boolean',
    ];

    /**
     * @return HasMany<WebshopProductVariant>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(WebshopProductVariant::class);
    }

    /**
     * @return HasMany<WebshopProductImage>
     */
    public function images(): HasMany
    {
        return $this
            ->hasMany(WebshopProductImage::class)
            ->orderBy('order');
    }

    /**
     * @return string
     */
    public function getPrimaryImageAttribute(): string
    {
        return $this->images()
            ->where('is_primary', true)
            ->first();
    }

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugConfig::get('category');
    }

    /**
     * @return WebshopProductFactory
     */
    protected static function newFactory(): WebshopProductFactory
    {
        return WebshopProductFactory::new();
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

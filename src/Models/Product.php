<?php

namespace VeiligLanceren\LaravelWebshopProduct\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use VeiligLanceren\LaravelWebshopProduct\Facades\SlugConfig;

class Product extends Model
{
    use SoftDeletes, HasSlug, HasFactory;

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
     * @return HasMany<ProductVariant>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * @return HasMany<ProductImage>
     */
    public function images(): HasMany
    {
        return $this
            ->hasMany(ProductImage::class)
            ->orderBy('order');
    }

    /**
     * @return MorphToMany
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categoryable');
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
     * @return ProductFactory
     */
    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

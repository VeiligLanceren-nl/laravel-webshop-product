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
        'featured',
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
        'featured' => 'boolean',
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
     * @return WebshopProductImage|null
     */
    public function getPrimaryImageAttribute(): ?WebshopProductImage
    {
        return $this->images()
            ->where('is_primary', true)
            ->first();
    }

    /**
     * @return float|null
     */
    public function getLengthAttribute(): ?float
    {
        return $this->dimensions['length'] ?? null;
    }

    /**
     * @return float|null
     */
    public function getWidthAttribute(): ?float
    {
        return $this->dimensions['width'] ?? null;
    }

    /**
     * @return float|null
     */
    public function getHeightAttribute(): ?float
    {
        return $this->dimensions['height'] ?? null;
    }

    /**
     * @param $value
     * @return void
     */
    public function setLengthAttribute($value): void
    {
        $this->dimensions = array_merge($this->dimensions ?? [], ['length' => (float) $value]);
    }

    /**
     * @param $value
     * @return void
     */
    public function setWidthAttribute($value): void
    {
        $this->dimensions = array_merge($this->dimensions ?? [], ['width' => (float) $value]);
    }

    /**
     * @param $value
     * @return void
     */
    public function setHeightAttribute($value): void
    {
        $this->dimensions = array_merge($this->dimensions ?? [], ['height' => (float) $value]);
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

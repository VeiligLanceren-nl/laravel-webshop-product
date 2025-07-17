<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Seo;

use Spatie\Sluggable\SlugOptions;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Seo\ISlugConfigService;

class SlugConfigService implements ISlugConfigService
{
    /**
     * @inheritDoc
     */
    public function get(string $key): SlugOptions
    {
        $config = config("product.seo.slug.{$key}");

        $options = SlugOptions::create()
            ->generateSlugsFrom($config['from'] ?? 'name')
            ->saveSlugsTo($config['to'] ?? 'slug')
            ->usingSeparator($config['separator'] ?? '-');

        if (($config['creation']['disable-on-creation'] ?? false) === true) {
            $options->doNotGenerateSlugsOnCreate();
        }

        if (($config['creation']['disable-on-change'] ?? false) === true) {
            $options->doNotGenerateSlugsOnUpdate();
        }

        return $options;
    }
}

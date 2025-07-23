<?php

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Seo\ISlugConfigService;

beforeEach(function () {
    uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

    Schema::create('fake_models', function ($table) {
        $table->id();
        $table->string('slug')->nullable();
        $table->string('name')->nullable();
        $table->string('title')->nullable();
    });

    $this->service = app(ISlugConfigService::class);
});

it('generates default slug from "name"', function () {
    Config::set('product.seo.slug.test', []);

    $model = new class extends Model {
        use HasSlug;

        protected $table = 'fake_models';
        public $timestamps = false;
        protected $guarded = [];

        public $name = 'Example WebshopProduct';

        public function getSlugOptions(): SlugOptions
        {
            return app(ISlugConfigService::class)->get('test');
        }
    };

    $model->save();

    expect($model->slug)->toBe('example-webshopproduct');
});

it('respects custom slug configuration', function () {
    Config::set('product.seo.slug.product', [
        'from' => 'title',
        'to' => 'slug',
        'separator' => '_',
        'creation' => [
            'disable-on-creation' => false,
            'disable-on-change' => true,
        ],
    ]);

    $model = new class extends Model {
        use HasSlug;

        protected $table = 'fake_models';
        public $timestamps = false;
        protected $guarded = [];

        public $title = 'My Custom Slug';

        public function getSlugOptions(): SlugOptions
        {
            return app(ISlugConfigService::class)->get('product');
        }
    };

    $model->save();

    expect($model->slug)->toBe('my_custom_slug');
});

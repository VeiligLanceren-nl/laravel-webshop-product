<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelMorphCategories\Models\MorphCategory;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return MorphCategory::with('children')->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?MorphCategory
    {
        return MorphCategory::with('children')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug): ?MorphCategory
    {
        return MorphCategory::where('slug', $slug)->first();
    }

    /**
     * @inheritDoc
     */
    public function getForModel(Model $model): Collection
    {
        return $model->morphCategories()->get();
    }

    /**
     * @inheritDoc
     */
    public function assign(Model $model, array|int $categories, bool $sync = false): void
    {
        $method = $sync ? 'sync' : 'attach';
        $model->morphCategories()->$method((array) $categories);
    }

    /**
     * @inheritDoc
     */
    public function detach(Model $model, array|int|null $categories = null): void
    {
        $model->morphCategories()->detach($categories);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): MorphCategory
    {
        return MorphCategory::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(MorphCategory $category, array $attributes): MorphCategory
    {
        $category->update($attributes);
        return $category;
    }

    /**
     * @inheritDoc
     */
    public function delete(MorphCategory $category): void
    {
        $category->delete();
    }
}

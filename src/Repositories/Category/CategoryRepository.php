<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\Category;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Category::with('children')->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Category
    {
        return Category::with('children')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }

    /**
     * @inheritDoc
     */
    public function getForModel(Model $model): Collection
    {
        return $model->categories()->get();
    }

    /**
     * @inheritDoc
     */
    public function assign(Model $model, array|int $categories, bool $sync = false): void
    {
        $method = $sync ? 'sync' : 'attach';
        $model->categories()->$method((array) $categories);
    }

    /**
     * @inheritDoc
     */
    public function detach(Model $model, array|int|null $categories = null): void
    {
        $model->categories()->detach($categories);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Category
    {
        return Category::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(Category $category, array $attributes): Category
    {
        $category->update($attributes);
        return $category;
    }

    /**
     * @inheritDoc
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}

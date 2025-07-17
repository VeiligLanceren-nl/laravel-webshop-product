<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\Category;

interface ICategoryRepository
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return Category|null
     */
    public function find(int $id): ?Category;

    /**
     * @param string $slug
     * @return Category|null
     */
    public function findBySlug(string $slug): ?Category;

    /**
     * @param Model $model
     * @return Collection
     */
    public function getForModel(Model $model): Collection;

    /**
     * @param Model $model
     * @param array|int $categories
     * @param bool $sync
     * @return void
     */
    public function assign(Model $model, array|int $categories, bool $sync = false): void;

    /**
     * @param Model $model
     * @param array|int|null $categories
     * @return void
     */
    public function detach(Model $model, array|int|null $categories = null): void;

    /**
     * @param array $attributes
     * @return Category
     */
    public function create(array $attributes): Category;

    /**
     * @param Category $category
     * @param array $attributes
     * @return Category
     */
    public function update(Category $category, array $attributes): Category;

    /**
     * @param Category $category
     * @return void
     */
    public function delete(Category $category): void;
}

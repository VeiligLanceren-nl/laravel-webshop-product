<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelMorphCategories\Models\MorphCategory;

interface ICategoryRepository
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return MorphCategory|null
     */
    public function find(int $id): ?MorphCategory;

    /**
     * @param string $slug
     * @return MorphCategory|null
     */
    public function findBySlug(string $slug): ?MorphCategory;

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
     * @return MorphCategory
     */
    public function create(array $attributes): MorphCategory;

    /**
     * @param MorphCategory $category
     * @param array $attributes
     * @return MorphCategory
     */
    public function update(MorphCategory $category, array $attributes): MorphCategory;

    /**
     * @param MorphCategory $category
     * @return void
     */
    public function delete(MorphCategory $category): void;
}

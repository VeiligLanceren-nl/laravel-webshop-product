<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelMorphCategories\Models\MorphCategory;

interface ICategoryService
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
     * @param array $data
     * @return MorphCategory
     */
    public function create(array $data): MorphCategory;

    /**
     * @param MorphCategory $category
     * @param array $data
     * @return MorphCategory
     */
    public function update(MorphCategory $category, array $data): MorphCategory;

    /**
     * @param MorphCategory $category
     * @return void
     */
    public function delete(MorphCategory $category): void;
}
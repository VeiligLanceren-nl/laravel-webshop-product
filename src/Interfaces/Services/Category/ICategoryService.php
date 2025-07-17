<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\Category;

interface ICategoryService
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
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function update(Category $category, array $data): Category;

    /**
     * @param Category $category
     * @return void
     */
    public function delete(Category $category): void;
}
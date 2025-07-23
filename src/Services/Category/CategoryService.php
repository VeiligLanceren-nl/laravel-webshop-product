<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Category;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelMorphCategories\Models\Category;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category\ICategoryService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;

class CategoryService implements ICategoryService
{
    /**
     * @param ICategoryRepository $repository
     */
    public function __construct(
        protected ICategoryRepository $repository
    ) {}

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Category
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Category
    {
        return $this->repository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Category $category, array $data): Category
    {
        return $this->repository->update($category, $data);
    }

    /**
     * @inheritDoc
     */
    public function delete(Category $category): void
    {
        $this->repository->delete($category);
    }
}
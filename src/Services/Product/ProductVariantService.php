<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductVariantService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

class ProductVariantService implements IProductVariantService
{
    /**
     * @var IProductVariantRepository
     */
    protected IProductVariantRepository $repository;

    public function __construct()
    {
        $this->repository = app(IProductVariantRepository::class);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return ProductVariant|null
     */
    public function find(int $id): ?ProductVariant
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return ProductVariant
     */
    public function create(array $data): ProductVariant
    {
        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductVariant|null
     */
    public function update(int $id, array $data): ?ProductVariant
    {
        return $this->repository->update($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

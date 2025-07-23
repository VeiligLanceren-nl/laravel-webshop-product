<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;

class ProductService implements IProductService
{
    /**
     * @var IProductRepository
     */
    protected IProductRepository $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(IProductRepository::class);
    }

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
    public function find(int $id): ?WebshopProduct
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): WebshopProduct
    {
        return $this->repository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(WebshopProduct $product, array $data): WebshopProduct
    {
        return $this->repository->update($product, $data);
    }

    /**
     * @inheritDoc
     */
    public function delete(WebshopProduct $product): bool
    {
        return $this->repository->delete($product);
    }
}
<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;

class ProductRepository implements IProductRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return WebshopProduct::query()->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?WebshopProduct
    {
        return WebshopProduct::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): WebshopProduct
    {
        return WebshopProduct::query()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(WebshopProduct $product, array $data): WebshopProduct
    {
        $product->update($data);

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function delete(WebshopProduct $product): bool
    {
        return $product->delete();
    }
}

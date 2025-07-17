<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;

class ProductRepository implements IProductRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Product::query()->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Product
    {
        return Product::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Product
    {
        return Product::query()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}

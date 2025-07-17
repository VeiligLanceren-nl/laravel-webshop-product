<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

class ProductImageRepository implements IProductImageRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return ProductImage::all();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?ProductImage
    {
        return ProductImage::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ProductImage
    {
        return ProductImage::query()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(ProductImage $productImage, array $data): bool
    {
        return $productImage->update($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(ProductImage $productImage): bool
    {
        return $productImage->delete();
    }
}
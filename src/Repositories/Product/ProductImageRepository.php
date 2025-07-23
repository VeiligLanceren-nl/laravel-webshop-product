<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

class ProductImageRepository implements IProductImageRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return WebshopProductImage::all();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?WebshopProductImage
    {
        return WebshopProductImage::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): WebshopProductImage
    {
        return WebshopProductImage::query()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(WebshopProductImage $productImage, array $data): bool
    {
        return $productImage->update($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(WebshopProductImage $productImage): bool
    {
        return $productImage->delete();
    }
}
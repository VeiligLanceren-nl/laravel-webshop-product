<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductImage;

interface IProductImageService
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return ProductImage|null
     */
    public function find(int $id): ?ProductImage;

    /**
     * @param array $data
     * @return ProductImage
     */
    public function create(array $data): ProductImage;

    /**
     * @param ProductImage $productImage
     * @param array $data
     * @return ProductImage
     */
    public function update(ProductImage $productImage, array $data): ProductImage;

    /**
     * @param ProductImage $productImage
     * @return bool
     */
    public function delete(ProductImage $productImage): bool;
}
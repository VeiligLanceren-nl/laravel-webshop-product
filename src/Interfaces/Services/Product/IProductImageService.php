<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;

interface IProductImageService
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return WebshopProductImage|null
     */
    public function find(int $id): ?WebshopProductImage;

    /**
     * @param array $data
     * @return WebshopProductImage
     */
    public function create(array $data): WebshopProductImage;

    /**
     * @param WebshopProductImage $productImage
     * @param array $data
     * @return WebshopProductImage
     */
    public function update(WebshopProductImage $productImage, array $data): WebshopProductImage;

    /**
     * @param WebshopProductImage $productImage
     * @return bool
     */
    public function delete(WebshopProductImage $productImage): bool;
}
<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;

interface IProductImageRepository
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
     * @return bool
     */
    public function update(WebshopProductImage $productImage, array $data): bool;

    /**
     * @param WebshopProductImage $productImage
     * @return bool
     */
    public function delete(WebshopProductImage $productImage): bool;
}
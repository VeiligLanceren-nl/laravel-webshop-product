<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;

interface IProductService
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return WebshopProduct|null
     */
    public function find(int $id): ?WebshopProduct;

    /**
     * @param array $data
     * @return WebshopProduct
     */
    public function create(array $data): WebshopProduct;

    /**
     * @param WebshopProduct $product
     * @param array $data
     * @return WebshopProduct
     */
    public function update(WebshopProduct $product, array $data): WebshopProduct;

    /**
     * @param WebshopProduct $product
     * @return bool
     */
    public function delete(WebshopProduct $product): bool;
}
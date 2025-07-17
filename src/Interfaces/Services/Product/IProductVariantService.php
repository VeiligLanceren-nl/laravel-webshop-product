<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;

interface IProductVariantService
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return ProductVariant|null
     */
    public function find(int $id): ?ProductVariant;

    /**
     * @param array $data
     * @return ProductVariant
     */
    public function create(array $data): ProductVariant;

    /**
     * @param int $id
     * @param array $data
     * @return ProductVariant|null
     */
    public function update(int $id, array $data): ?ProductVariant;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

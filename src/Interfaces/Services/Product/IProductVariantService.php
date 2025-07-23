<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product;

use Illuminate\Support\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;

interface IProductVariantService
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return WebshopProductVariant|null
     */
    public function find(int $id): ?WebshopProductVariant;

    /**
     * @param array $data
     * @return WebshopProductVariant
     */
    public function create(array $data): WebshopProductVariant;

    /**
     * @param int $id
     * @param array $data
     * @return WebshopProductVariant|null
     */
    public function update(int $id, array $data): ?WebshopProductVariant;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;

interface IProductVariantRepository
{
    /**
     * Get all product variants.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find a product variant by ID.
     *
     * @param int $id
     * @return WebshopProductVariant|null
     */
    public function find($id): WebshopProductVariant | null;

    /**
     * Create a new product variant.
     *
     * @param array $data
     * @return WebshopProductVariant
     */
    public function create(array $data): WebshopProductVariant;

    /**
     * Update an existing product variant.
     *
     * @param int $id
     * @param array $data
     * @return WebshopProductVariant|null
     */
    public function update($id, array $data): WebshopProductVariant | null;

    /**
     * Delete a product variant.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id): bool;
}
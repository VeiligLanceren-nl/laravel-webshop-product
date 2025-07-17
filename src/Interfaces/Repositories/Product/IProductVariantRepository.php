<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;

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
     * @return ProductVariant|null
     */
    public function find($id): ProductVariant | null;

    /**
     * Create a new product variant.
     *
     * @param array $data
     * @return ProductVariant
     */
    public function create(array $data): ProductVariant;

    /**
     * Update an existing product variant.
     *
     * @param int $id
     * @param array $data
     * @return ProductVariant|null
     */
    public function update($id, array $data): ProductVariant | null;

    /**
     * Delete a product variant.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id): bool;
}
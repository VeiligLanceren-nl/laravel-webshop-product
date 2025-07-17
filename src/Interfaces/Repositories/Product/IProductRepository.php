<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;

interface IProductRepository
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product;

    /**
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * @param Product $product
     * @param array $data
     * @return Product
     */
    public function update(Product $product, array $data): Product;

    /**
     * @param Product $product
     * @return bool
     */
    public function delete(Product $product): bool;
}
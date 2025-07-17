<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

class ProductVariantRepository implements IProductVariantRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return ProductVariant::all();
    }

    /**
     * @inheritDoc
     */
    public function find($id): ProductVariant | null
    {
        return ProductVariant::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ProductVariant
    {
        return ProductVariant::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data): ProductVariant
    {
        $variant = $this->find($id);

        if ($variant) {
            $variant->update($data);
        }

        return $variant;
    }

    /**
     * @inheritDoc
     */
    public function delete($id): bool
    {
        $variant = $this->find($id);

        if ($variant) {
            return $variant->delete();
        }

        return false;
    }
}
<?php

namespace VeiligLanceren\LaravelWebshopProduct\Repositories\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

class ProductVariantRepository implements IProductVariantRepository
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return WebshopProductVariant::all();
    }

    /**
     * @inheritDoc
     */
    public function find($id): WebshopProductVariant | null
    {
        return WebshopProductVariant::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): WebshopProductVariant
    {
        return WebshopProductVariant::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data): WebshopProductVariant
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
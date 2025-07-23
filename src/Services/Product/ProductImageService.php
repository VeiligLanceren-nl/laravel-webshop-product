<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductImageService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

class ProductImageService implements IProductImageService
{
    /**
     * @var IProductImageRepository
     */
    protected IProductImageRepository $repository;

    public function __construct()
    {
        $this->repository = app()->make(IProductImageRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?WebshopProductImage
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): WebshopProductImage
    {
        if (!empty($data['is_primary'])) {
            $this->unsetPrimaryImages($data['webshop_product_id']);
        }

        return $this->repository->create($data);
    }

    /**
     * @param WebshopProductImage $productImage
     * @param array $data
     * @return WebshopProductImage
     */
    public function update(WebshopProductImage $productImage, array $data): WebshopProductImage
    {
        if (!empty($data['is_primary'])) {
            $this->unsetPrimaryImages($productImage->webshop_product_id, $productImage->id);
        }

        $this->repository->update($productImage, $data);

        return $productImage->refresh();
    }

    /**
     * @param WebshopProductImage $productImage
     * @return bool
     */
    public function delete(WebshopProductImage $productImage): bool
    {
        return $this->repository->delete($productImage);
    }

    /**
     * @param int $productId
     * @param int|null $exceptId
     * @return void
     */
    protected function unsetPrimaryImages(int $productId, ?int $exceptId = null): void
    {
        $images = $this->repository->all()
            ->where('webshop_product_id', $productId)
            ->when($exceptId, fn ($collection) => $collection->where('id', '!=', $exceptId));

        foreach ($images as $img) {
            if ($img->is_primary) {
                $this->repository->update($img, ['is_primary' => false]);
            }
        }
    }
}
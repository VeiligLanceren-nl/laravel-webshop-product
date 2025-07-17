<?php

namespace VeiligLanceren\LaravelWebshopProduct\Services\Product;

use Illuminate\Database\Eloquent\Collection;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductImage;
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
    public function find(int $id): ?ProductImage
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ProductImage
    {
        if (!empty($data['is_primary'])) {
            $this->unsetPrimaryImages($data['product_id']);
        }

        return $this->repository->create($data);
    }

    /**
     * @param ProductImage $productImage
     * @param array $data
     * @return ProductImage
     */
    public function update(ProductImage $productImage, array $data): ProductImage
    {
        if (!empty($data['is_primary'])) {
            $this->unsetPrimaryImages($productImage->product_id, $productImage->id);
        }

        $this->repository->update($productImage, $data);

        return $productImage->refresh();
    }

    /**
     * @param ProductImage $productImage
     * @return bool
     */
    public function delete(ProductImage $productImage): bool
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
            ->where('product_id', $productId)
            ->when($exceptId, fn ($collection) => $collection->where('id', '!=', $exceptId));

        foreach ($images as $img) {
            if ($img->is_primary) {
                $this->repository->update($img, ['is_primary' => false]);
            }
        }
    }
}
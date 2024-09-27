<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Product;
use App\Models\Product\ProductType;
use App\Models\ProductInterface;

class EloquentProductCatalogoue implements ProductCatalogueInterface
{

    public function existsForType(ProductType $productType): bool
    {
        return Product::query()->where('product_type', $productType->value)->exists();
    }

    public function save(ProductInterface $product): void
    {
        if ($product instanceof Product) {
            $product->save();
            return;
        }

        throw new \RuntimeException('Product must be an instance of Product');
    }
}

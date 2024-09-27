<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\Product\ProductType;

interface ProductCatalogueInterface
{
    public function existsForType(ProductType $productType): bool;
    public function save(Product $product): void;
}

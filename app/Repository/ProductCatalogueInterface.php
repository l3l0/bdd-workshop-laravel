<?php

namespace App\Repository;

use App\Models\ProductInterface;
use App\Models\Product\ProductType;

interface ProductCatalogueInterface
{
    public function existsForType(ProductType $productType): bool;
    public function save(ProductInterface $product): void;
}

<?php

namespace App\Service\CreateProduct;

use App\Models\Product\ProductType;
use Ramsey\Uuid\UuidInterface;

readonly class Command
{
    public function __construct(
        public UuidInterface $id,
        public ProductType $productType,
        public string $name,
        public bool $isCollective,
        public bool $isLeasingProduct,
        public array $rpRatings
    ) {}
}

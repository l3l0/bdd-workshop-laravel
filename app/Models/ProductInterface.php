<?php

namespace App\Models;

use App\Models\Product\ProductType;

interface ProductInterface
{
    public function getId(): string;
    public function getProductType(): ?ProductType;
    public function getName(): ?string;
    public function isCollective(): bool;
    public function isLeasingProduct(): bool;
    public function getRpRatings(): array;
}

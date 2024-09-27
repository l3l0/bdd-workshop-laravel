<?php

declare(strict_types=1);

namespace App\Models\Product;

enum ProductType: int
{
    case None = 0;
    case LpsMax = 1;
    case PasMax = 2;
}

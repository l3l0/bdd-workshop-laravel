<?php

declare(strict_types=1);

namespace App\Factory;

use App\Models\Product;
use App\Models\ProductInterface;
use App\Service\CreateProduct\Command;

class EloquentProductCreator implements ProductCreatorInterface
{

    public function create(Command $command): ProductInterface
    {
        $product = Product::factory()->make([
            'id' => $command->id->toString(),
            'product_type' => $command->productType->value,
            'name' => $command->name,
            'is_collective' => $command->isCollective,
            'is_leasing_product' => $command->isLeasingProduct,
            'rp_ratings' => json_encode($command->rpRatings, JSON_THROW_ON_ERROR),
        ]);

        return $product;
    }
}

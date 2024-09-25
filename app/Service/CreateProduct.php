<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\ProductCreatorInterface;
use App\Repository\ProductCatalogueInterface;

readonly class CreateProduct
{
    public function __construct(private ProductCatalogueInterface $productCatalogue, private ProductCreatorInterface $productCreator)
    {}

    public function __invoke(CreateProduct\Command $command): void
    {
        if ($this->productCatalogue->existsForType($command->productType)) {
            return;
        }
        $product = $this->productCreator->create($command);
        $this->productCatalogue->save($product);
    }
}

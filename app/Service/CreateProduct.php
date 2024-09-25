<?php

namespace App\Service;

use App\Factory\ProductCreatorInterface;
use App\Repository\ProductCatalogueInterface;

readonly class CreateProduct
{
    public function __construct(private ProductCatalogueInterface $productCatalogue, private ProductCreatorInterface)
    {}

    public function __invoke(CreateProduct\Command $command): void
    {
        $product = $this->productCreator->create($command);
        if ($this->productCatalogue->existsForType($command->productType)) {
            return;
        }
        $this->productCatalogue->save($product);
    }
}

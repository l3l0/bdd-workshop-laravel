<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\ProductCreatorInterface;
use App\Repository\ProductCatalogueInterface;

readonly class CreateProduct
{
    private ProductCatalogueInterface $productCatalogue;
    private ProductCreatorInterface $productCreator;

    public function __construct(
        ProductCatalogueInterface $productCatalogue,
        ProductCreatorInterface $productCreator
    ) {
        $this->productCatalogue = $productCatalogue;
        $this->productCreator = $productCreator;
    }

    public function __invoke(CreateProduct\Command $command): void
    {
        if ($this->productCatalogue->existsForType($command->productType)) {
            return;
        }
        $product = $this->productCreator->create($command);
        $this->productCatalogue->save($product);
    }
}

<?php

namespace spec\App\Service;

use App\Models\Product;
use App\Service\CreateProduct;
use App\Repository\ProductCatalogueInterface;
use App\Factory\ProductCreatorInterface;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class CreateProductSpec extends ObjectBehavior
{
    function let(ProductCatalogueInterface $productCatalogue, ProductCreatorInterface $productCreator)
    {
        $this->beConstructedWith(
            $productCatalogue,
            $productCreator
        );
    }

    function it_saves_created_product_in_catalog(
        ProductCatalogueInterface $productCatalogue,
        ProductCreatorInterface $productCreator,
        Product $product
    ) {
        // arrange
        $command = new CreateProduct\Command(
            id: Uuid::fromString('f1b9f4b0-0b1e-4b7b-8b3e-3f0b6f1f5f7d'),
            productType: Product\ProductType::LpsMax,
            name: 'LPS MAX',
            isCollective: false,
            isLeasingProduct: true,
            rpRatings: [
                'a' => '0.0080',
                'b' => '0.0182',
                'c' => '0.0110',
                's' => '0.0030',
            ],
        );
        $productCreator->create($command)->willReturn($product);
        $productCatalogue->existsForType(Product\ProductType::LpsMax)->willReturn(false);

        // act
        $this->__invoke($command);

        // assert
        $productCatalogue->save($product)->shouldHaveBeenCalled();

    }
}

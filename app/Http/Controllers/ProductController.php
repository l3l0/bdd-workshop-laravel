<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product\ProductType;
use App\Repository\ProductCatalogueInterface;
use App\Service\CreateProduct;
use App\Service\CreateProduct\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    public function create(Request $request, CreateProduct $createProduct): JsonResponse
    {
        $id = Uuid::uuid7();
        $command = new Command(
            $id,
            ProductType::from($request->integer('product_type')),
            $request->string('name')->value(),
            (bool) $request->input('is_collective'),
            (bool) $request->input('is_leasing_product'),
            $request->all('rp_ratings'),
        );
        $createProduct($command);

        return response()->json([
            'id' => $id->toString(),
            'product_type' => $command->productType->value,
            'name' => $command->name,
            'is_collective' => $command->isCollective,
            'is_leasing_product' => $command->isLeasingProduct,
            'rp_ratings' => $command->rpRatings
        ], 201);
    }

    public function delete(string $id, ProductCatalogueInterface $productCatalogue): JsonResponse
    {
        $productCatalogue->delete(UUid::fromString($id));
        return response()->json([
            'id' => $id
        ], 200);
    }
}

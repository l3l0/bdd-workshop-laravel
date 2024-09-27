<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements ProductInterface
{
    use HasFactory;

    protected $table = 'products';

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductType(): ?ProductType
    {
        return ProductType::from($this->product_type);
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function isCollective(): bool
    {
        return $this->isCollective;
    }

    public function isLeasingProduct(): bool
    {
        return $this->isLeasingProduct;
    }

    public function getRpRatings(): array
    {
        $ratings = json_decode($this->rpRatings, true, 512, JSON_THROW_ON_ERROR);

        return $ratings;
    }
}

<?php

namespace App\Factory;

use App\Models\ProductInterface;
use App\Service\CreateProduct\Command;

interface ProductCreatorInterface
{
    public function create(Command $command): ProductInterface;
}

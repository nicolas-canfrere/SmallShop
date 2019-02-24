<?php

namespace Domain\Product\Signature;

use Domain\Core\Signature\RepositoryInterface;
use Domain\Product\Product;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function oneByAlias(string $alias): ?Product;
}

<?php

namespace Tests\Domain\Product;

use Domain\Product\Product;
use Domain\Product\ValueObject\ProductName;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class ProductTestCase extends TestCase
{
    protected function createProduct($id, $name, $price, $alias = 'alias', $description = 'description')
    {
        return Product::create(
            $id,
            new ProductName($name),
            new Money($price, new Currency('EUR')),
            $alias,
            $description
        );
    }
}

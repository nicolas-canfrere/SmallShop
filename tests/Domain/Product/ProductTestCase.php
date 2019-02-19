<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 19/02/19
 * Time: 01:21
 */

namespace Domain\Tests\Product;


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

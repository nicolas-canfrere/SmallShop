<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 12:15
 */

namespace Domain\Product\Signature;


use Domain\Core\Signature\RepositoryInterface;
use Domain\Product\Product;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function oneByAlias(string $alias): ?Product;
}

<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 12:12
 */

namespace Domain\Cart\Signature;


use Domain\Product\Signature\ProductInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

interface CartRowInterface
{
    public static function FromArray(array $array): CartRowInterface;

    public function add(int $numberOfItem);

    public function remove(int $numberOfItem);

    public function getProduct(): ProductInterface;

    public function getCount(): int;

    public function getTotalPrice(): Money;

    public function toArray(): array;

    public function getProductPrice(): Money;

    public function getProductName(): ProductName;

    public function getProductId(): string;
}

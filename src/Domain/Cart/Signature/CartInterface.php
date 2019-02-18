<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 18:32
 */

namespace Domain\Cart\Signature;


use Domain\Product\Signature\ProductInterface;

interface CartInterface
{
    public function addItem(ProductInterface $product, int $count = 1);

    public function removeItem(ProductInterface $product, int $count = 1);

    public function deleteRow(string $id);

    public function totalPrice();

    public function count();

    public function clear();

    public function itemIsRegistred(string $id): bool;
}

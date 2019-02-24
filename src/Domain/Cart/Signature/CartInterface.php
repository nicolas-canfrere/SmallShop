<?php

namespace Domain\Cart\Signature;

use Domain\Cart\Exception\CartException;
use Domain\Product\Signature\ProductInterface;
use Money\Money;

/**
 * Interface CartInterface.
 */
interface CartInterface
{
    /**
     * @param ProductInterface $product
     * @param int              $count
     *
     * @throws CartException
     */
    public function addItem(ProductInterface $product, int $count = 1): void;

    /**
     * @param ProductInterface $product
     * @param int              $count
     *
     * @throws CartException
     */
    public function removeItem(ProductInterface $product, int $count = 1): void;

    /**
     * @param string $id
     */
    public function deleteRow(string $id): void;

    /**
     * @return Money
     */
    public function totalPrice(): Money;

    /**
     * @return int
     */
    public function count(): int;

    public function clear(): void;

    /**
     * @param string $id
     *
     * @return bool
     */
    public function itemIsRegistred(string $id): bool;
}

<?php

namespace Domain\Cart\Signature;

use Domain\Product\Signature\ProductInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

/**
 * Interface CartRowInterface.
 */
interface CartRowInterface
{
    /**
     * @param string           $id
     * @param ProductInterface $product
     * @param int              $count
     *
     * @return CartRowInterface
     */
    public static function create(string $id, ProductInterface $product, int $count = 1): CartRowInterface;

    /**
     * @param array $array
     *
     * @return CartRowInterface
     */
    public static function fromArray(array $array): CartRowInterface;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param int $numberOfItem
     */
    public function add(int $numberOfItem): void;

    /**
     * @param int $numberOfItem
     */
    public function remove(int $numberOfItem): void;

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @return Money
     */
    public function getTotalPrice(): Money;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return Money
     */
    public function getProductPrice(): Money;

    /**
     * @return ProductName
     */
    public function getProductName(): ProductName;

    /**
     * @return string
     */
    public function getProductId(): string;
}

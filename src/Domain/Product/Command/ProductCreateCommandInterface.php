<?php

namespace Domain\Product\Command;


use Domain\Product\ValueObject\ProductName;
use Money\Money;

interface ProductCreateCommandInterface
{
    public function getName(): ProductName;

    /**
     * @param ProductName $name
     */
    public function setName(ProductName $name): void;

    /**
     * @return Money
     */
    public function getPrice(): Money;

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void;
}
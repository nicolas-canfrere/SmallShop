<?php

namespace Domain\Product\Command;


use Domain\Product\ValueObject\ProductName;
use Money\Money;

interface ProductCreateCommandInterface
{
    public function getName(): ?ProductName;
    public function setName(ProductName $name): void;

    public function getPrice(): ?Money;
    public function setPrice(Money $price): void;

    public function getDescription(): ?string;
    public function setDescription(string $description): void;

    public function getUuid(): ?string;
    public function setUuid(string $uuid): void;
}

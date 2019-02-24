<?php

namespace Domain\Product\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Product\Product;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

interface ProductUpdateCommandInterface extends CommandInterface
{
    public static function fromProduct(Product $product);

    public function getName(): ?ProductName;

    public function setName(ProductName $name): ProductUpdateCommandInterface;

    public function getPrice(): ?Money;

    public function setPrice(Money $price): ProductUpdateCommandInterface;

    public function getDescription(): ?string;

    public function setDescription(string $description): ProductUpdateCommandInterface;

    public function getUuid(): ?string;

    public function setUuid(string $uuid): ProductUpdateCommandInterface;

    public function getAlias(): ?string;

    public function setAlias(string $alias): ProductUpdateCommandInterface;

    public function isOnSale(): ?bool;

    public function setOnSale(bool $onSale): ProductUpdateCommandInterface;

    public function getOriginal(): ?Product;

    public function setOriginal(?Product $original): ProductUpdateCommandInterface;
}

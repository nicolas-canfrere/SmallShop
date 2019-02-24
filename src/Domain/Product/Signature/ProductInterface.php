<?php

namespace Domain\Product\Signature;

use Domain\Core\Signature\EntityInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

interface ProductInterface extends EntityInterface
{
    public function getId(): string;

    public function getName(): ProductName;

    public function getPrice(): Money;

    public function getAlias(): string;

    public function getDescription(): string;
}

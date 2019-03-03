<?php

namespace Domain\Product\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

/**
 * Interface ProductCreateCommandInterface
 */
interface ProductCreateCommandInterface extends CommandInterface
{
    /**
     * @return ProductName|null
     */
    public function getName(): ?ProductName;

    /**
     * @param ProductName $name
     */
    public function setName(ProductName $name): void;

    /**
     * @return Money|null
     */
    public function getPrice(): ?Money;

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void;

    /**
     * @return ArrayCollection
     */
    public function getTags(): ArrayCollection;

    /**
     * @param ArrayCollection $tags
     *
     * @return ProductCreateCommandInterface
     */
    public function setTags(ArrayCollection $tags): ProductCreateCommandInterface;
}

<?php

namespace Domain\Product\Signature;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Core\Signature\EntityInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

/**
 * Interface ProductInterface
 */
interface ProductInterface extends EntityInterface
{

    /**
     * @return ProductName
     */
    public function getName(): ProductName;

    /**
     * @return Money
     */
    public function getPrice(): Money;

    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return bool
     */
    public function isOnSale(): bool;
    /**
     * @param TagInterface $tag
     *
     * @return ProductInterface
     */
    public function addTag(TagInterface $tag): ProductInterface;

    /**
     * @param TagInterface $tag
     *
     * @return ProductInterface
     */
    public function removeTag(TagInterface $tag): ProductInterface;

    /**
     * @return ArrayCollection
     */
    public function getTags(): ArrayCollection;

    /**
     * @param ArrayCollection $tags
     *
     * @return ProductInterface
     */
    public function setTags($tags): ProductInterface;
}

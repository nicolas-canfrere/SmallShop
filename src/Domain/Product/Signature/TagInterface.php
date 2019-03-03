<?php

namespace Domain\Product\Signature;


use Doctrine\Common\Collections\ArrayCollection;
use Domain\Core\Signature\EntityInterface;

/**
 * Interface TagInterface
 */
interface TagInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param ProductInterface $product
     *
     * @return TagInterface
     */
    public function addProduct(ProductInterface $product): TagInterface;

    /**
     * @param ProductInterface $product
     *
     * @return TagInterface
     */
    public function removeProduct(ProductInterface $product): TagInterface;

    /**
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection;

    /**
     * @param ArrayCollection $products
     *
     * @return TagInterface
     */
    public function setProducts($products): TagInterface;
}

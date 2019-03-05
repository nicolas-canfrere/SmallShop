<?php

namespace Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\TagInterface;

/**
 * Class Tag.
 */
class Tag implements TagInterface
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var ArrayCollection
     */
    protected $products;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product): TagInterface
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product): TagInterface
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts($products): TagInterface
    {
        $this->products = $products;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

<?php

namespace Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\TagInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

/**
 * Class Product
 */
class Product implements ProductInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var ProductName
     */
    protected $name;

    /**
     * @var Money
     */
    protected $price;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $onSale = false;

    /**
     * @var ArrayCollection
     */
    protected $tags;

    public static function create(string $id, ProductName $name, Money $price, string $alias, string $description)
    {
        $product = new static();
        $product->id = $id;
        $product->name = $name;
        $product->price = $price;
        $product->alias = $alias;
        $product->description = $description;
        $product->tags = new ArrayCollection();

        return $product;
    }

    public function update(ProductName $name, Money $price, string $alias, string $description, bool $onSale)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->price = $price;
        $this->description = $description;
        $this->onSale = $onSale;
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
    public function getName(): ProductName
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function isOnSale(): bool
    {
        return $this->onSale;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(TagInterface $tag): ProductInterface
    {
        if(!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addProduct($this);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(TagInterface $tag): ProductInterface
    {
        if($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeProduct($this);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(): ArrayCollection
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags($tags): ProductInterface
    {
        $this->tags = $tags;

        return $this;
    }

    public function __toString()
    {
        return $this->name->getName();
    }


}

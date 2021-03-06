<?php

namespace Bundles\ProductBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Product\Command\ProductUpdateCommandHandler;
use Domain\Product\Command\ProductUpdateCommandInterface;
use Domain\Product\Product;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

class ProductUpdateCommand implements ProductUpdateCommandInterface
{
    /**
     * @var ProductName
     */
    public $name;

    /**
     * @var Money
     */
    public $price;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var bool
     */
    public $onSale;

    /**
     * @var Product|null
     */
    public $original;
    /**
     * @var ArrayCollection
     */
    public $tags;

    public static function fromProduct(Product $product)
    {
        $static = new static();
        $static->price = $product->getPrice();
        $static->name = $product->getName();
        $static->description = $product->getDescription();
        $static->uuid = $product->getId();
        $static->alias = $product->getAlias();
        $static->onSale = $product->isOnSale();
        $static->tags = $product->getTags();
        $static->original = $product;

        return $static;
    }

    /**
     * @return ProductName
     */
    public function getName(): ?ProductName
    {
        return $this->name;
    }

    /**
     * @param ProductName $name
     *
     * @return ProductUpdateCommand
     */
    public function setName(ProductName $name): ProductUpdateCommandInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): ?Money
    {
        return $this->price;
    }

    /**
     * @param Money $price
     *
     * @return ProductUpdateCommand
     */
    public function setPrice(Money $price): ProductUpdateCommandInterface
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return ProductUpdateCommand
     */
    public function setDescription(string $description): ProductUpdateCommandInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return ProductUpdateCommand
     */
    public function setUuid(string $uuid): ProductUpdateCommandInterface
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return ProductUpdateCommand
     */
    public function setAlias(string $alias): ProductUpdateCommandInterface
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnSale(): ?bool
    {
        return $this->onSale;
    }

    /**
     * @param bool $onSale
     *
     * @return ProductUpdateCommand
     */
    public function setOnSale(bool $onSale): ProductUpdateCommandInterface
    {
        $this->onSale = $onSale;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getOriginal(): ?Product
    {
        return $this->original;
    }

    /**
     * @param Product|null $original
     *
     * @return ProductUpdateCommand
     */
    public function setOriginal(?Product $original): ProductUpdateCommandInterface
    {
        $this->original = $original;

        return $this;
    }

    public function handleBy(): string
    {
        return ProductUpdateCommandHandler::class;
    }

    /**
     * @return Collection|ArrayCollection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection|ArrayCollection $tags
     *
     * @return ProductUpdateCommandInterface
     */
    public function setTags(Collection $tags): ProductUpdateCommandInterface
    {
        $this->tags = $tags;

        return $this;
    }
}

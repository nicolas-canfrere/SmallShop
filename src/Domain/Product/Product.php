<?php

namespace Domain\Product;

use Domain\Product\Signature\ProductInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;

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

    public static function create(string $id, ProductName $name, Money $price, string $alias, string $description)
    {
        $product = new static();
        $product->id = $id;
        $product->name = $name;
        $product->price = $price;
        $product->alias = $alias;
        $product->description = $description;

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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return ProductName
     */
    public function getName(): ProductName
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isOnSale(): bool
    {
        return $this->onSale;
    }
}

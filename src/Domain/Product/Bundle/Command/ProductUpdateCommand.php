<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 19:24
 */

namespace Domain\Product\Bundle\Command;


use Domain\Product\Product;
use Money\Money;

class ProductUpdateCommand
{
    /**
     * @var string
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

    public static function fromProduct(Product $product)
    {
        $static              = new static();
        $static->price       = $product->getPrice();
        $static->name        = $product->getName();
        $static->description = $product->getDescription();
        $static->uuid        = $product->getId();
        $static->alias       = $product->getAlias();
        $static->onSale      = $product->isOnSale();
        $static->original    = $product;

        return $static;
    }
}

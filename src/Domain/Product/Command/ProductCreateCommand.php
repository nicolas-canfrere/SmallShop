<?php

namespace Domain\Product\Command;


use Domain\Product\ValueObject\ProductName;
use Money\Money;

class ProductCreateCommand
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


}

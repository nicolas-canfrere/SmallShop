<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:45
 */

namespace Domain\Product\Bundle\Command;


use Money\Money;

class ProductCreateCommand
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


}

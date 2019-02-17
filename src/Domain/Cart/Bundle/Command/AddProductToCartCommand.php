<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 17:49
 */

namespace Domain\Cart\Bundle\Command;

/**
 * Class AddProductToCartCommand
 *
 * @package Domain\Cart\Bundle\Command
 */
class AddProductToCartCommand
{
    /**
     * @var string
     */
    public $productId;
    /**
     * @var int
     */
    public $quantity;

    public static function FromArray(array $params)
    {
        $command            = new static();
        $command->productId = $params['id'];
        $command->quantity  = $params['quantity'];

        return $command;
    }
}

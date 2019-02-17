<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 08:22
 */

namespace Domain\Cart\Bundle\Command;


class RemoveProductFromCartCommand
{
    /**
     * @var string
     */
    public $productId;
    /**
     * @var int|string
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

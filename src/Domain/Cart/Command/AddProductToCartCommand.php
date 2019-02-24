<?php

namespace Domain\Cart\Command;

/**
 * Class AddProductToCartCommand.
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

    /**
     * @param array $params
     *
     * @return AddProductToCartCommand
     */
    public static function fromArray(array $params)
    {
        $command            = new static();
        $command->productId = $params['id'];
        $command->quantity  = $params['quantity'];

        return $command;
    }
}

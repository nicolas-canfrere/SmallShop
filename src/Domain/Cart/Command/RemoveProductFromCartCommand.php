<?php

namespace Domain\Cart\Command;

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

    public static function fromArray(array $params)
    {
        $command            = new static();
        $command->productId = $params['id'];
        $command->quantity  = $params['quantity'];

        return $command;
    }
}

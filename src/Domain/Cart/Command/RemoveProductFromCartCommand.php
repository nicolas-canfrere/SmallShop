<?php

namespace Domain\Cart\Command;

/**
 * Class RemoveProductFromCartCommand.
 */
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

    /**
     * @param array $params
     *
     * @return RemoveProductFromCartCommand
     */
    public static function fromArray(array $params)
    {
        $command = new static();
        $command->productId = $params['id'];
        $command->quantity = $params['quantity'];

        return $command;
    }
}

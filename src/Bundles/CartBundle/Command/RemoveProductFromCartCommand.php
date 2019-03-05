<?php

namespace Bundles\CartBundle\Command;

use Domain\Cart\Command\RemoveProductFromCartCommandHandler;
use Domain\Cart\Command\RemoveProductFromCartCommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class RemoveProductFromCartCommand.
 */
class RemoveProductFromCartCommand implements RemoveProductFromCartCommandInterface
{
    /**
     * @var string
     */
    protected $productId;

    /**
     * @var int|string
     */
    protected $quantity;

    /**
     * @var CustomerInterface|null
     */
    protected $customer;

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
        $command->customer = $params['customer'];

        return $command;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * {@inheritdoc}
     */
    public function handleBy(): string
    {
        return RemoveProductFromCartCommandHandler::class;
    }
}

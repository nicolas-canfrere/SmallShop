<?php

namespace Bundles\CartBundle\Command;

use Domain\Cart\Command\AddProductToCartCommandHandler;
use Domain\Cart\Command\AddProductToCartCommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class AddProductToCartCommand.
 */
class AddProductToCartCommand implements AddProductToCartCommandInterface
{
    /**
     * @var string
     */
    protected $productId;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @param array $params
     *
     * @return AddProductToCartCommand
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
    public function getQuantity(): int
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
        return AddProductToCartCommandHandler::class;
    }
}

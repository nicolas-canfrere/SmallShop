<?php

namespace Domain\Cart\Event;


use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Product\Signature\ProductInterface;

/**
 * Class ProductAddedToCartEvent
 */
final class ProductAddedToCartEvent extends Event
{
    /**
     * @var ProductInterface
     */
    protected $product;
    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var CustomerInterface|null
     */
    protected $customer;
    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * ProductAddedToCartEvent constructor.
     *
     * @param ProductInterface $product
     * @param int $quantity
     * @param CustomerInterface|null $customer
     *
     * @throws \Exception
     */
    public function __construct(ProductInterface $product, int $quantity, ?CustomerInterface $customer)
    {
        $this->product = $product;
        $this->quantity  = $quantity;
        $this->customer  = $customer;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

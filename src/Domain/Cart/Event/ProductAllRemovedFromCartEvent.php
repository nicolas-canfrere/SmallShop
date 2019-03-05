<?php

namespace Domain\Cart\Event;

use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Product\Signature\ProductInterface;

/**
 * Class ProductAllRemovedFromCartEvent
 */
final class ProductAllRemovedFromCartEvent extends Event
{
    /**
     * @var ProductInterface
     */
    protected $product;
    /**
     * @var CustomerInterface|null
     */
    protected $customer;
    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * ProductAllRemovedFromCartEvent constructor.
     *
     * @param ProductInterface $product
     * @param CustomerInterface|null $customer
     *
     * @throws \Exception
     */
    public function __construct(ProductInterface $product, ?CustomerInterface $customer)
    {
        $this->product  = $product;
        $this->customer = $customer;
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

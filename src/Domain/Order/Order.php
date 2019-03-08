<?php

namespace Domain\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Order\Signature\OrderInterface;
use Domain\Order\Signature\OrderItemInterface;

/**
 * Class Order.
 */
class Order implements OrderInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var ArrayCollection
     */
    protected $orderItems;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var string
     */
    protected $deliveryAddress;

    /**
     * @var string
     */
    protected $billingAddress;

    /**
     * @var string
     */
    protected $state = OrderInterface::ORDER_STATE_STARTED;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public static function create(
        string $id
    ) {
        $static = new static();

        $static->id = $id;

        return $static;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function addOrderItem(OrderItemInterface $orderItem): OrderInterface
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomer(CustomerInterface $customer): OrderInterface
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliveryAddress(string $deliveryAddress): OrderInterface
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(string $billingAddress): OrderInterface
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliveryAddress(): string
    {
        return $this->deliveryAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress(): string
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getState(): string
    {
        return $this->state;
    }
}

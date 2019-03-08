<?php

namespace Domain\Order\Signature;

use Doctrine\Common\Collections\Collection;
use Domain\Core\Signature\EntityInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Interface OrderInterface.
 */
interface OrderInterface extends EntityInterface
{
    const ORDER_STATE_STARTED = 'started';
    const ORDER_STATE_PENDING = 'pending';
    const ORDER_STATE_CONFIRMED = 'confirmed';
    const ORDER_STATE_CANCELLED = 'cancelled';

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable;

    /**
     * @param OrderItemInterface $orderItem
     *
     * @return OrderInterface
     */
    public function addOrderItem(OrderItemInterface $orderItem): OrderInterface;

    /**
     * @return Collection
     */
    public function getOrderItems(): Collection;

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface;

    /**
     * @return string
     */
    public function getDeliveryAddress(): string;

    /**
     * @return string
     */
    public function getBillingAddress(): string;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param CustomerInterface $customer
     *
     * @return OrderInterface
     */
    public function setCustomer(CustomerInterface $customer): OrderInterface;

    /**
     * @param string $deliveryAddress
     *
     * @return OrderInterface
     */
    public function setDeliveryAddress(string $deliveryAddress): OrderInterface;

    /**
     * @param string $billingAddress
     *
     * @return OrderInterface
     */
    public function setBillingAddress(string $billingAddress): OrderInterface;
}

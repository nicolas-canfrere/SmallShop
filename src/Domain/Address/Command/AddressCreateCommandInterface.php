<?php

namespace Domain\Address\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Interface AddressCreateCommandInterface.
 */
interface AddressCreateCommandInterface extends CommandInterface
{
    /**
     * @return CustomerInterface
     */
    public function getOwner(): CustomerInterface;

    /**
     * @return string|null
     */
    public function getFullname(): ?string;

    /**
     * @return string|null
     */
    public function getStreet(): ?string;

    /**
     * @return string
     */
    public function getPostalCode(): ?string;

    /**
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * @return string|null
     */
    public function getCountry(): ?string;
}

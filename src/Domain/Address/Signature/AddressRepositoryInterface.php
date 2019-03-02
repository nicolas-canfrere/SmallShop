<?php

namespace Domain\Address\Signature;

use Domain\Core\Signature\RepositoryInterface;

/**
 * Interface AddressRepositoryInterface.
 */
interface AddressRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return mixed
     */
    public function getAllByCustomerId(string $id);
}

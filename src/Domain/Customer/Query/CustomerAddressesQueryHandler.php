<?php

namespace Domain\Customer\Query;

use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\QueryBus\QueryInterface;

/**
 * Class CustomerAddressesQueryHandler
 */
class CustomerAddressesQueryHandler implements QueryHandlerInterface
{

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function handle(QueryInterface $query)
    {
        dump($query);

        return null;
    }
}

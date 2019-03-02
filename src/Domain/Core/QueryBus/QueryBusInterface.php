<?php

namespace Domain\Core\QueryBus;

/**
 * Interface QueryBusInterface.
 */
interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function handle(QueryInterface $query);
}

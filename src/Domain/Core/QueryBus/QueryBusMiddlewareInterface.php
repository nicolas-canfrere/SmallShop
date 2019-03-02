<?php

namespace Domain\Core\QueryBus;

/**
 * Interface QueryBusMiddlewareInterface.
 */
interface QueryBusMiddlewareInterface
{
    /**
     * @param QueryInterface $query
     * @param callable       $next
     *
     * @return mixed
     */
    public function execute(QueryInterface $query, callable $next);
}

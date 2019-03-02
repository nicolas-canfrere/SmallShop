<?php

namespace Domain\Core\QueryBus;

/**
 * Interface QueryBusMiddlewareInterface
 * @package Domain\Core\QueryBus
 */
interface QueryBusMiddlewareInterface
{
    /**
     * @param QueryInterface $query
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(QueryInterface $query, callable $next);
}

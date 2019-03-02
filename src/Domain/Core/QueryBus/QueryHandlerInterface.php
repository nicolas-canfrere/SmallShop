<?php

namespace Domain\Core\QueryBus;

/**
 * Interface QueryHandlerInterface
 */
interface QueryHandlerInterface
{
    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function handle(QueryInterface $query);
}

<?php

namespace Domain\Core\QueryBus;

use Domain\Core\QueryBus\Exception\NoHandlerForQueryException;

/**
 * Interface QueryHandlerProviderInterface
 */
interface QueryHandlerProviderInterface
{
    /**
     * @param QueryHandlerInterface $handler
     * @param string|null $customId
     */
    public function registerHandler(QueryHandlerInterface $handler, ?string $customId = ''): void;

    /**
     * @param QueryInterface $query
     *
     * @return QueryHandlerInterface
     * @throws NoHandlerForQueryException
     */
    public function getHandlerForQuery(QueryInterface $query): QueryHandlerInterface;
}

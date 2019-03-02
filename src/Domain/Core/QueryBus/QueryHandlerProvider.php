<?php

namespace Domain\Core\QueryBus;

use Domain\Core\QueryBus\Exception\NoHandlerForQueryException;

/**
 * Class QueryHandlerProvider.
 */
class QueryHandlerProvider implements QueryHandlerProviderInterface, QueryBusMiddlewareInterface
{
    /**
     * @var QueryHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * {@inheritdoc}
     */
    public function execute(QueryInterface $query, callable $next)
    {
        $handler = $this->getHandlerForQuery($query);

        return $handler->handle($query);
    }

    /**
     * {@inheritdoc}
     */
    public function registerHandler(QueryHandlerInterface $handler, ?string $customId = ''): void
    {
        $key = $customId ? $customId : get_class($handler);
        $this->handlers[$key] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerForQuery(QueryInterface $query): QueryHandlerInterface
    {
        $key = $query->handleBy();

        if (empty($this->handlers[$key])) {
            throw new NoHandlerForQueryException(get_class($query));
        }

        return $this->handlers[$key];
    }
}

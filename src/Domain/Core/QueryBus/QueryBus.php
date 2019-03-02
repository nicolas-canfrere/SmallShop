<?php

namespace Domain\Core\QueryBus;

/**
 * Class QueryBus.
 */
class QueryBus implements QueryBusInterface
{
    /**
     * @var \Closure
     */
    protected $middlewareChain;

    public function __construct($middlewares = [])
    {
        $this->middlewareChain = $this->createMiddlewareChain($middlewares);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(QueryInterface $query)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($query);
    }

    /**
     * @param array $middlewares
     *
     * @return \Closure
     */
    public function createMiddlewareChain($middlewares = []): \Closure
    {
        $next = function () {
        };
        while ($middleware = array_pop($middlewares)) {
            $next = function ($command) use ($middleware, $next) {
                return $middleware->execute($command, $next);
            };
        }

        return $next;
    }
}

<?php

namespace Domain\Core\CommandBus;

/**
 * Class CommandBus.
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerProviderInterface
     */
    protected $commandHandlerProvider;

    /**
     * @var \Closure
     */
    protected $middlewareChain;

    /**
     * CommandBus constructor.
     *
     * @param array $middlewares
     */
    public function __construct($middlewares = [])
    {
        $this->middlewareChain = $this->createMiddlewareChain($middlewares);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CommandInterface $command)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($command);
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

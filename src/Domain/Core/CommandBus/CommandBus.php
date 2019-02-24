<?php

namespace Domain\Core\CommandBus;

class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerProviderInterface
     */
    protected $commandHandlerProvider;

    protected $middlewareChain;

    /**
     * CommandBus constructor.
     *
     * @param CommandHandlerProviderInterface $commandHandlerProvider
     */
    public function __construct($middlewares = [])
    {
        $this->middlewareChain = $this->createMiddlewareChain($middlewares);
    }

    public function handle(CommandInterface $command)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($command);
    }

    public function createMiddlewareChain($middlewares = [])
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

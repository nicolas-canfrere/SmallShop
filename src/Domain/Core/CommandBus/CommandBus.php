<?php

namespace Domain\Core\CommandBus;


class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerProviderInterface
     */
    protected $commandHandlerProvider;

    /**
     * CommandBus constructor.
     * @param CommandHandlerProviderInterface $commandHandlerProvider
     */
    public function __construct(CommandHandlerProviderInterface $commandHandlerProvider)
    {
        $this->commandHandlerProvider = $commandHandlerProvider;
    }


    public function handle(CommandInterface $command)
    {
        $handler = $this->commandHandlerProvider->getHandlerForCommand($command);

        $handler->handle($command);
    }

    public function process($command)
    {
        $middlewares = [
            function ($command, $next) {
                $command->text = '"' . $command->text . '"';
                return $next($command);
            },
            function ($command, $next) {
                $command->text = '<p>' . $command->text . '</p>';
                return $next($command);
            },
            function ($command, $next) {
                $command->text = '<div>' . $command->text . '</div>';
                return $command;
            },
        ];
        $next = function () {
        };
        while ($middleware = array_pop($middlewares)) {

            $next = function ($command) use ($middleware, $next) {
                return $middleware($command, $next);
            };
        }

        return $next($command);
    }
}
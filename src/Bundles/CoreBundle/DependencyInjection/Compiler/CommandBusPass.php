<?php

namespace Bundles\CoreBundle\DependencyInjection\Compiler;

use Domain\Core\CommandBus\CommandBus;
use Domain\Core\CommandBus\CommandHandlerProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandBusPass.
 */
class CommandBusPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (
        !$container->has(CommandHandlerProviderInterface::class)
        ) {
            return;
        }

        $handlerProviderDefinition = $container->findDefinition(CommandHandlerProviderInterface::class);

        $taggedServices = $container->findTaggedServiceIds('domain.command.handler');

        foreach ($taggedServices as $id => $tags) {
            $handlerProviderDefinition->addMethodCall('registerHandler', [new Reference($id)]);
        }

        $commandBusConfig = $container->getParameter('core.commandbus');

        $container
            ->setDefinition(
                CommandBus::class,
                new Definition(
                    CommandBus::class,
                    [
                        array_map(
                            function ($id) {
                                return new Reference($id);
                            },
                            $commandBusConfig['middlewares']
                        ),
                    ]
                )
            );
    }
}

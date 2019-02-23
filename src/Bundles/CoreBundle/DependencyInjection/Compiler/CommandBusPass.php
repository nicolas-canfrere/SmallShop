<?php

namespace Bundles\CoreBundle\DependencyInjection\Compiler;


use Domain\Core\CommandBus\CommandBus;
use Domain\Core\CommandBus\CommandHandlerProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandBusPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (
            !$container->has(CommandHandlerProviderInterface::class) &&
            !$container->has(CommandBus::class)
        ) {
            return;
        }

        $handlerProviderDefinition = $container->findDefinition(CommandHandlerProviderInterface::class);

        $taggedServices = $container->findTaggedServiceIds('domain.command.handler');

        foreach ($taggedServices as $id => $tags) {
            $handlerProviderDefinition->addMethodCall('registerHandler', [new Reference($id)]);
        }
    }
}
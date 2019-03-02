<?php

namespace Bundles\CoreBundle\DependencyInjection\Compiler;

use Domain\Core\QueryBus\QueryBus;
use Domain\Core\QueryBus\QueryHandlerProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class QueryBusPass
 */
class QueryBusPass implements CompilerPassInterface
{


    public function process(ContainerBuilder $container)
    {
        if (
        ! $container->has(QueryHandlerProviderInterface::class)
        ) {
            return;
        }

        $handlerProviderDefinition = $container->findDefinition(QueryHandlerProviderInterface::class);

        $taggedServices = $container->findTaggedServiceIds('domain.query.handler');

        foreach ($taggedServices as $id => $tags) {
            $handlerProviderDefinition->addMethodCall('registerHandler', [new Reference($id)]);
        }

        $queryBusConfig = $container->getParameter('core.querybus');

        $container
            ->setDefinition(
                QueryBus::class,
                new Definition(
                    QueryBus::class,
                    [
                        array_map(
                            function ($id) {
                                return new Reference($id);
                            },
                            $queryBusConfig['middlewares']
                        ),
                    ]
                )
            );
    }
}

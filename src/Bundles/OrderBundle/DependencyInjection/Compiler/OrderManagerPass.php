<?php

namespace Bundles\OrderBundle\DependencyInjection\Compiler;

use Domain\Order\OrderManager\OrderManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class OrderManagerPass
 */
class OrderManagerPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('order');

        $container
            ->setDefinition(
                OrderManager::class,
                new Definition(
                    OrderManager::class,
                    [
                        array_map(
                            function ($id) {
                                return new Reference($id);
                            },
                            $config['middlewares']
                        ),
                    ]
                )
            );

    }
}

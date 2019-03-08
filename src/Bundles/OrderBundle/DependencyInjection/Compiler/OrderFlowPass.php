<?php

namespace Bundles\OrderBundle\DependencyInjection\Compiler;

use Domain\Order\OrderManager\OrderFlow;
use Domain\Order\Signature\OrderFlowInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class OrderFlowPass
 */
class OrderFlowPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('order');

        $container
            ->setDefinition(
                OrderFlowInterface::class,
                new Definition(
                    OrderFlow::class,
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

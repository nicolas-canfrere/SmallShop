<?php

namespace Bundles\OrderBundle;


use Bundles\OrderBundle\DependencyInjection\Compiler\OrderFlowPass;
use Bundles\OrderBundle\DependencyInjection\OrderExtension;
use Domain\Order\Signature\OrderFlowMiddlewareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class OrderBundle
 */
class OrderBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new OrderExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerForAutoconfiguration(OrderFlowMiddlewareInterface::class)
                  ->addTag('domain.order.manager_middleware');

        $container->addCompilerPass(new OrderFlowPass());
    }


}

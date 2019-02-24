<?php

namespace Bundles\CartBundle;

use Bundles\CartBundle\DependencyInjection\CartExtension;
use Domain\Core\Signature\CommandHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CartBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CartExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
                  ->addTag('tactician.handler', ['typehints' => true, 'bus' => 'default']);
    }
}

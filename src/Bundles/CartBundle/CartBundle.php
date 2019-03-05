<?php

namespace Bundles\CartBundle;

use Bundles\CartBundle\DependencyInjection\CartExtension;
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
    }
}

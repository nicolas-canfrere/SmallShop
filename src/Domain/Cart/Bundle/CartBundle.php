<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 18:38
 */

namespace Domain\Cart\Bundle;


use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Cart\Bundle\DependencyInjection\CartExtension;
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

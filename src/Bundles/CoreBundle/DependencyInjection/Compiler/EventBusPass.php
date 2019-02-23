<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 21/02/19
 * Time: 23:19
 */

namespace Bundles\CoreBundle\DependencyInjection\Compiler;


use Domain\Core\Event\EventBusInterface;
use Domain\Core\Event\EventListenerProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EventBusPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (
            !$container->has(EventListenerProviderInterface::class) &&
            !$container->has(EventBusInterface::class)
        ) {
            return;
        }

        $eventListenerProviderDefinition = $container->findDefinition(EventListenerProviderInterface::class);

        $taggedServices = $container->findTaggedServiceIds('eventbus.listener');

        foreach ($taggedServices as $id => $tags) {
            $eventListenerProviderDefinition->addMethodCall('addListener', [new Reference($id)]);
        }
    }
}
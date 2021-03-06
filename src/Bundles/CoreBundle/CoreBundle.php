<?php

namespace Bundles\CoreBundle;

use Bundles\CoreBundle\DependencyInjection\Compiler\CommandBusPass;
use Bundles\CoreBundle\DependencyInjection\Compiler\EventBusPass;
use Bundles\CoreBundle\DependencyInjection\Compiler\QueryBusPass;
use Bundles\CoreBundle\DependencyInjection\CoreExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Domain\Core\CommandBus\CommandHandlerInterface as DomainCommandHandler;
use Domain\Core\Event\ListenerInterface;
use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CoreExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('tactician.handler', ['typehints' => true, 'bus' => 'default']);

        $container->registerForAutoconfiguration(ListenerInterface::class)
            ->addTag('eventbus.listener');
        $container->registerForAutoconfiguration(DomainCommandHandler::class)
            ->addTag('domain.command.handler');

        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
                  ->addTag('domain.query.handler');

        $container->addCompilerPass(new EventBusPass());
        $container->addCompilerPass(new CommandBusPass());
        $container->addCompilerPass(new QueryBusPass());

        $this->addRegisterMappingsPass($container);
    }

    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = [
            realpath(__DIR__.'/Resources/config/doctrine/money') => 'Money',
        ];
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, [], false));
        }
    }
}

<?php

namespace Bundles\StockBundle;

use Bundles\StockBundle\DependencyInjection\StockExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Domain\Core\Signature\CommandHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StockBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new StockExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
                  ->addTag('tactician.handler', ['typehints' => true, 'bus' => 'default']);

        $this->addRegisterMappingsPass($container);
    }

    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = [
            realpath(__DIR__.'/Resources/config/doctrine/mapping') => 'Domain\Stock',
        ];
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, [], false));
        }
    }
}

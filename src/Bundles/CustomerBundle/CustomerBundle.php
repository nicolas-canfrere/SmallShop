<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 19/02/19
 * Time: 23:29
 */

namespace Bundles\CustomerBundle;

use Bundles\CustomerBundle\DependencyInjection\CustomerExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Domain\Core\Signature\CommandHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CustomerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CustomerExtension();
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
        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine/mapping') => 'Domain\Customer',
        );
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, [], false));
        }
    }
}
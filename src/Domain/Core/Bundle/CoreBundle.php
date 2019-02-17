<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 11:14
 */

namespace Domain\Core\Bundle;


use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Domain\Core\Bundle\DependencyInjection\CoreExtension;
use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Core\Signature\QueryHandlerInterface;
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
        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
                  ->addTag('tactician.handler', ['typehints' => true, 'bus' => 'query']);

        $this->addRegisterMappingsPass($container);


    }

    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine/money') => 'Money',
        );
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, [], false));
        }
    }
}

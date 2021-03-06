<?php

namespace Bundles\ProductBundle\DependencyInjection;

use Bundles\ProductBundle\Doctrine\Type\ProductNameType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ProductExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension('doctrine')) {
            $container->prependExtensionConfig(
                'doctrine',
                ['dbal' => ['types' => [ProductNameType::NAME => ProductNameType::class]]]
            );
            $container->prependExtensionConfig(
                'doctrine',
                ['dbal' => ['mapping_types' => [ProductNameType::NAME => 'string']]]
            );
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'product';
    }
}

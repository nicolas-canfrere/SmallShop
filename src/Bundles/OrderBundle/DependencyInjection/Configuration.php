<?php

namespace Bundles\OrderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('order');
        $rootNode = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('order');

        $rootNode
            ->children()/* root children */
                ->arrayNode('middlewares')/* start middlewares */
                    ->defaultValue([])
                    //->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->scalarPrototype()->end()
                ->end()/* end middlewares */
            ->end()/* end root children */;

        return $treeBuilder;
    }
}

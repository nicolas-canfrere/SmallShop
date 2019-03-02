<?php

namespace Bundles\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('core');
        $rootNode = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('core');

        $rootNode
            ->children()
                ->arrayNode('commandbus')
                    ->children()
                        ->arrayNode('middlewares')
                            ->requiresAtLeastOneElement()
                            ->scalarPrototype()->end()
                            ->validate()
                                ->ifTrue(function ($config) {
                                    $isPresent = in_array('domain.command_handler_provider', $config);
                                    $isLast = end($config) == 'domain.command_handler_provider';

                                    if(!$isPresent) { return true; }

                                    return $isPresent && !$isLast;
                                })
                                ->thenInvalid('"domain.command_handler_provider" doit être présent et être le dernier middleware')
                            ->end()/* end validate */
                        ->end()/* end array node */
                    ->end()/* end children */
                ->end()/* end array node */
                ->arrayNode('querybus')
                    ->children()
                        ->arrayNode('middlewares')
                            ->requiresAtLeastOneElement()
                            ->scalarPrototype()->end()
                            ->validate()
                                ->ifTrue(function ($config){
                                    $isPresent = in_array('domain.query_handler_provider', $config);
                                    $isLast = end($config) == 'domain.query_handler_provider';

                                    if(!$isPresent) { return true; }

                                    return $isPresent && !$isLast;
                                })
                                ->thenInvalid('"domain.query_handler_provider" doit être présent et être le dernier middleware')
                            ->end()/* end validate */
                        ->end()/* end array node */
                    ->end()/* end children */
                ->end()/* end array node */
            ->end()/* end children */;

        return $treeBuilder;
    }
}

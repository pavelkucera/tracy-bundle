<?php

/**
 * Copyright (c) Pavel Kučera (http://github.com/pavelkucera), Shipito (www.shipito.com)
 */

namespace Kucera\TracyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * @author Pavel Kučera
 * @author Shipito (www.shipito.com)
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kucera_tracy');

        $rootNode->children()
            ->booleanNode('log_automatically')
                ->defaultTrue()
            ->end()
            ->scalarNode('log_directory')
                ->defaultNull()
            ->end()
            ->arrayNode('emails')
                ->prototype('scalar')->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

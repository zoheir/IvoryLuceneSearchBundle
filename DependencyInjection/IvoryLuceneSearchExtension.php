<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\LuceneSearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * Ivory lucene search extension.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class IvoryLuceneSearchExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $resources = array('services.xml');
        foreach($resources as $resource) {
            $loader->load($resource);
        }

        if (!empty($config)) {
            $this->loadIndexes($config, $container);
        }
    }

    /**
     * Loads indexees configuration
     *
     * @param array                                                   $config    The configuration.
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container The container.
     */
    protected function loadIndexes(array $config, ContainerBuilder $container)
    {
        $container
            ->getDefinition('ivory_lucene_search')
            ->addMethodCall('setIndexes', array($config));
    }
}

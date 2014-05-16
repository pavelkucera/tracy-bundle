<?php

/**
 * Copyright (c) Pavel Kučera (http://github.com/pavelkucera), Shipito (www.shipito.com)
 */

namespace Kucera\TracyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @author Pavel Kučera
 * @author Shipito (www.shipito.com)
 */
class TracyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $dir = $config['log_directory'];
        if ($dir === NULL) {
            $dir = $container->getParameter('kernel.logs_dir') . '/tracy';
        }

        $container->setParameter('tracy.log_directory', $dir);
        $container->setParameter('tracy.emails', $config['emails']);
        $container->setParameter('tracy.log_automatically', $config['log_automatically']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($dir !== FALSE) {
            $this->createLogDir($dir);
        }
    }


    private function createLogDir($path)
    {
        $fs = new Filesystem();
        $fs->mkdir($path);
    }
}

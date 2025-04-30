<?php
declare(strict_types=1);

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace Pimcore\Bundle\NewsletterBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @internal
 */
final class CustomReportsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../../config')
        );

        //only register custom reports adapter, if the custom reports bundle is installed
        if ($container->hasDefinition('pimcore.custom_report.adapter.factories')) {
            $loader->load('custom_reports.yaml');

            $serviceLocator = $container->getDefinition('pimcore_newsletter.address_source_adapter.factories');
            $arguments = $serviceLocator->getArgument(0);
            $arguments['reportAdapter'] = new Reference('pimcore_newsletter.document.newsletter.factory.report');
            $serviceLocator->setArgument(0, $arguments);
        }
    }
}

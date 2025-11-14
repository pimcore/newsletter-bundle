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

namespace Pimcore\Bundle\NewsletterBundle;

use Pimcore\Bundle\AdminBundle\PimcoreAdminBundle;
use Pimcore\Bundle\NewsletterBundle\DependencyInjection\Compiler\CustomReportsPass;
use Pimcore\Bundle\NewsletterBundle\DependencyInjection\PimcoreNewsletterExtension;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @deprecated version 2.3
 */
class PimcoreNewsletterBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;
    use PackageVersionTrait;

    public function __construct()
    {
        trigger_deprecation(
            'pimcore/google-marketing-bundle',
            '2.1',
            'The GoogleMarketingBundle is deprecated and will be discontinued with Pimcore Studio.'
        );
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new PimcoreNewsletterExtension();
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/pimcorenewsletter/js/startup.js',
            '/bundles/pimcorenewsletter/js/document/newsletter.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/settings.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/sendingPanel.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/plaintextPanel.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/addressSourceAdapters/default.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/addressSourceAdapters/csvList.js',
            '/bundles/pimcorenewsletter/js/document/newsletters/addressSourceAdapters/report.js',
            '/bundles/pimcorenewsletter/js/object/classes/data/newsletterActive.js',
            '/bundles/pimcorenewsletter/js/object/classes/data/newsletterConfirmed.js',
            '/bundles/pimcorenewsletter/js/object/tags/newsletterActive.js',
            '/bundles/pimcorenewsletter/js/object/tags/newsletterConfirmed.js',
        ];
    }

    public function getCssPaths(): array
    {
        return [
            '/bundles/pimcorenewsletter/css/icons.css',
        ];
    }

    public function getEditmodeJsPaths(): array
    {
        return [];
    }

    public function getEditmodeCssPaths(): array
    {
        return [];
    }

    public function getInstaller(): Installer
    {
        return $this->container->get(Installer::class);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CustomReportsPass());
    }

    public static function registerDependentBundles(BundleCollection $collection): void
    {
        $collection->addBundle(new PimcoreAdminBundle(), 60);
    }
}

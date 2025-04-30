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

namespace Pimcore\Bundle\NewsletterBundle\CustomReports\Tool\Adapter;

use Pimcore\Bundle\CustomReportsBundle\Tool\Adapter\CustomReportAdapterFactoryInterface;
use Pimcore\Bundle\CustomReportsBundle\Tool\Config;
use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\AddressSourceAdapterFactoryInterface;
use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\AddressSourceAdapterInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @internal
 */
final class ReportAddressSourceAdapterFactory implements AddressSourceAdapterFactoryInterface
{
    private ServiceLocator $reportAdapterServiceLocator;

    public function __construct(ServiceLocator $reportAdapterServiceLocator)
    {
        $this->reportAdapterServiceLocator = $reportAdapterServiceLocator;
    }

    public function create(array $params): ReportAdapter|AddressSourceAdapterInterface
    {
        $config = Config::getByName($params['reportId']);
        $configuration = $config->getDataSourceConfig();

        $reportAdapterType = $configuration->type;

        if (!$this->reportAdapterServiceLocator->has($reportAdapterType)) {
            throw new \RuntimeException(sprintf('Could not find Custom Report Adapter with type %s', $reportAdapterType));
        }

        /** @var CustomReportAdapterFactoryInterface $adapterFactory */
        $adapterFactory = $this->reportAdapterServiceLocator->get($reportAdapterType);
        $adapter = $adapterFactory->create($configuration, $config);

        return new ReportAdapter($params['emailFieldName'], $adapter);
    }
}

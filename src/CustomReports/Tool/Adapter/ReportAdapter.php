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

use Pimcore\Bundle\CustomReportsBundle\Tool\Adapter\CustomReportAdapterInterface;
use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\AddressSourceAdapterInterface;
use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\SendingParamContainer;

/**
 * @internal
 */
final class ReportAdapter implements AddressSourceAdapterInterface
{
    protected string $emailFieldName;

    protected CustomReportAdapterInterface $reportAdapter;

    /**
     * @var string[]
     */
    protected array $emailAddresses;

    protected int $elementsTotal = 0;

    protected ?array $list = null;

    public function __construct(string $emailFieldName, CustomReportAdapterInterface $reportAdapter)
    {
        $this->emailFieldName = $emailFieldName;
        $this->reportAdapter = $reportAdapter;
    }

    protected function getListing(): array
    {
        $result = $this->reportAdapter->getData(null, $this->emailFieldName, 'ASC', null, null);

        $this->list = $result['data'];
        $this->elementsTotal = (int)$result['total'];

        $this->emailAddresses = [];
        foreach ($this->list as $row) {
            if (isset($row[$this->emailFieldName])) {
                $this->emailAddresses[] = $row[$this->emailFieldName];
            }
        }

        return $this->list;
    }

    public function getMailAddressesForBatchSending(): array
    {
        if (!$this->list) {
            $this->getListing();
        }

        $containers = [];
        foreach ($this->emailAddresses as $address) {
            $containers[] = new SendingParamContainer($address, ['emailAddress' => $address]);
        }

        return $containers;
    }

    public function getParamsForTestSending(string $emailAddress): SendingParamContainer
    {
        if (!$this->list) {
            $this->getListing();
        }

        return new SendingParamContainer($emailAddress, current($this->list));
    }

    public function getTotalRecordCount(): int
    {
        if (!$this->list) {
            $this->getListing();
        }

        return $this->elementsTotal;
    }

    public function getParamsForSingleSending(int $limit, int $offset): array
    {
        if (!$this->list) {
            $this->getListing();
        }

        $listing = $this->list;

        $containers = [];

        for ($i = $offset; $i < ($offset + $limit); $i++) {
            if (isset($listing[$i][$this->emailFieldName])) {
                // as $listing is array type we can send all so every column can be used as placeholder in email
                $containers[] = new SendingParamContainer($listing[$i][$this->emailFieldName], $listing[$i]);
            }
        }

        return $containers;
    }
}

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

namespace Pimcore\Bundle\NewsletterBundle\Document\Newsletter\AddressSourceAdapter;

use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\AddressSourceAdapterInterface;
use Pimcore\Bundle\NewsletterBundle\Document\Newsletter\SendingParamContainer;

/**
 * @internal
 */
final class CsvList implements AddressSourceAdapterInterface
{
    /**
     * @var string[]
     */
    protected array $emailAddresses;

    /**
     * IAddressSourceAdapter constructor.
     *
     */
    public function __construct(array $params)
    {
        $this->emailAddresses = array_filter(explode(',', $params['csvList']));
    }

    public function getMailAddressesForBatchSending(): array
    {
        $containers = [];
        foreach ($this->emailAddresses as $address) {
            $containers[] = new SendingParamContainer($address, ['emailAddress' => $address]);
        }

        return $containers;
    }

    public function getParamsForTestSending(string $emailAddress): SendingParamContainer
    {
        return new SendingParamContainer($emailAddress, [
            'emailAddress' => current($this->emailAddresses),
        ]);
    }

    public function getTotalRecordCount(): int
    {
        return count($this->emailAddresses);
    }

    public function getParamsForSingleSending(int $limit, int $offset): array
    {
        $addresses = array_slice($this->emailAddresses, $offset, $limit);

        $containers = [];
        foreach ($addresses as $address) {
            $containers[] = new SendingParamContainer($address, ['emailAddress' => $address]);
        }

        return $containers;
    }
}

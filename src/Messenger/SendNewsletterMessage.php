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

namespace Pimcore\Bundle\NewsletterBundle\Messenger;

/**
 * @internal
 */
class SendNewsletterMessage
{
    public function __construct(protected string $tmpStoreId, protected string $hostUrl)
    {
    }

    public function getTmpStoreId(): string
    {
        return $this->tmpStoreId;
    }

    public function getHostUrl(): string
    {
        return $this->hostUrl;
    }
}

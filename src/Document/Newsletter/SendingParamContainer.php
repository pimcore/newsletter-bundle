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

namespace Pimcore\Bundle\NewsletterBundle\Document\Newsletter;

class SendingParamContainer
{
    /**
     * @internal
     *
     */
    protected string $email;

    /**
     * @internal
     *
     */
    protected ?array $params = null;

    /**
     * SendingParamContainer constructor.
     *
     */
    public function __construct(string $email, ?array $params = null)
    {
        $this->email = $email;
        $this->params = $params;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParams(?array $params): void
    {
        $this->params = $params;
    }
}

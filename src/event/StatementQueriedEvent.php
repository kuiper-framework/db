<?php

/*
 * This file is part of the Kuiper package.
 *
 * (c) Ye Wenbin <wenbinye@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace kuiper\db\event;

use kuiper\db\StatementInterface;

class StatementQueriedEvent
{
    /**
     * @var StatementInterface
     */
    private $statement;
    /**
     * @var \PDOException|null
     */
    private $exception;

    /**
     * StatementQueriedEvent constructor.
     */
    public function __construct(StatementInterface $statement, \PDOException $exception = null)
    {
        $this->statement = $statement;
        $this->exception = $exception;
    }

    public function getStatement(): StatementInterface
    {
        return $this->statement;
    }

    public function getException(): ?\PDOException
    {
        return $this->exception;
    }
}

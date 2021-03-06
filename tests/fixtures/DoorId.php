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

namespace kuiper\db\fixtures;

use kuiper\db\annotation\Column;
use kuiper\db\annotation\Embeddable;

/**
 * @Embeddable()
 */
class DoorId
{
    /**
     * @Column("door_code")
     *
     * @var string
     */
    private $value;

    /**
     * DoorId constructor.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

<?php

namespace Package\Gemba\BankAccount;

use InvalidArgumentException;

class CurrentAmount
{
    /**
     * @param int $amount
     */
    public function __construct(
        public readonly int $amount
    ) {
    }
}

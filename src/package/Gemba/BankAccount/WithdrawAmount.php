<?php

namespace Package\Gemba\BankAccount;

use InvalidArgumentException;

class WithdrawAmount
{
    /**
     * @param int $amount
     */
    public function __construct(
        public readonly int $amount
    ) {
        if ($amount > 0) {
            throw new InvalidArgumentException('Amount cannot be positive');
        }
    }
}

<?php

namespace Package\Gemba\BankAccount;

class AccountId
{
    /**
     * @param string $id
     */
    public function __construct(
        private string $id
    ) {
    }
}

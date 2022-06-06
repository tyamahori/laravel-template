<?php

namespace Package\Gemba\BankAccount;

use InvalidArgumentException;

class BankAccount
{
    /**
     * @param AccountId $accountId
     * @param CurrentAmount $currentAmount
     */
    public function __construct(
        private AccountId $accountId,
        private CurrentAmount $currentAmount
    ) {
    }

    /**
     * @param WithdrawAmount $withdrawAmount
     * @return $this
     */
    public function withdraw(WithdrawAmount $withdrawAmount): self
    {
        $balance = $this->currentAmount->amount + $withdrawAmount->amount;
        if ($balance < 0) {
            throw new InvalidArgumentException('Not enough money');
        }

        $entity = clone $this;

        $entity->currentAmount = new CurrentAmount($balance);

        return $entity;
    }

    /**
     * @return CurrentAmount
     */
    public function newAmount(): CurrentAmount
    {
        return $this->currentAmount;
    }
}

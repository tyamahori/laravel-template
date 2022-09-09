<?php

namespace Package\Gemba\ValueObject;

use DateInterval;
use DateTimeInterface;

class Age
{
    /**
     * @param DateTimeInterface $now
     * @param DateTimeInterface $dateOfBirth
     */
    public function __construct(
        private DateTimeInterface $now,
        private DateTimeInterface $dateOfBirth
    ) {
    }

    /**
     * @return int
     */
    public function currentAge(): int
    {
        return $this->now->diff($this->dateOfBirth)->y;
    }
}

<?php

namespace Package\Gemba\Polymorphism;

class Charge
{
    /**
     * @param FeeInterface $fee
     */
    public function __construct(
        private FeeInterface $fee
    ) {
    }

    /**
     * @return Yen
     */
    public function yen(): Yen
    {
        return $this->fee->yen();
    }
}

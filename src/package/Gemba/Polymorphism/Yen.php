<?php

namespace Package\Gemba\Polymorphism;

class Yen
{
    /**
     * @param int $amount
     */
    public function __construct(
        public readonly int $amount
    ) {
    }

    /**
     * @param Yen $yen
     * @return Yen
     */
    public function add(Yen $yen): Yen
    {
        return new self($this->amount + $yen->amount);
    }
}

<?php

namespace Package\Gemba\Polymorphism;

class AdultFee implements FeeInterface
{
    /**
     * @return Yen
     */
    public function yen(): Yen
    {
        return new Yen(1000);
    }

    public function label(): string
    {
        return '大人料金';
    }
}

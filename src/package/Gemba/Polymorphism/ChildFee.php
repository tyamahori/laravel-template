<?php

namespace Package\Gemba\Polymorphism;

class ChildFee implements FeeInterface
{
    /**
     * @return Yen
     */
    public function yen(): Yen
    {
        return new Yen(300);
    }

    public function label(): string
    {
        return '子供料金';
    }
}

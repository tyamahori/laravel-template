<?php

namespace Package\Gemba\Polymorphism;

use InvalidArgumentException;

enum FeeType
{
    case ADULT;
    case CHILD;

    /**
     * @return FeeInterface
     */
    public function fee(): FeeInterface
    {
        return match ($this) {
            self::CHILD => new ChildFee(),
            self::ADULT => new AdultFee(),
        };
    }
}

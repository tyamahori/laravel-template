<?php

namespace Package\Gemba\Polymorphism;

use InvalidArgumentException;

enum FeeType: string
{
    case ADULT = 'adult';
    case CHILD = 'child';

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

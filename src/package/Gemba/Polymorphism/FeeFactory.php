<?php

namespace Package\Gemba\Polymorphism;

use InvalidArgumentException;

class FeeFactory
{
    /**
     * @param string $type
     * @return FeeInterface
     */
    public static function byType(string $type): FeeInterface
    {
        return match ($type) {
            'child' => new ChildFee(),
            'adult' => new AdultFee(),
            default => throw new InvalidArgumentException('Invalid fee type'),
        };
    }
}

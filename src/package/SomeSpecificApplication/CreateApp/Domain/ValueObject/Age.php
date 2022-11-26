<?php
declare(strict_types=1);

namespace Package\SomeSpecificApplication\CreateApp\Domain\ValueObject;

use InvalidArgumentException;

class Age
{
    /**
     * @param int $age
     */
    public function __construct(
        public readonly int $age
    ) {
        if ($age < 0) {
            throw new InvalidArgumentException('Age must be greater than 0');
        }

        if ($age > 100) {
            throw new InvalidArgumentException('Age must be less than 100');
        }
    }
}

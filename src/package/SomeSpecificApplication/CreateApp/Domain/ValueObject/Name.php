<?php

namespace Package\SomeSpecificApplication\CreateApp\Domain\ValueObject;

use InvalidArgumentException;

class Name
{
    /**
     * @param string $name
     */
    public function __construct(
        public readonly string $name
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (mb_strlen($name) > 40) {
            throw new InvalidArgumentException('Name cannot be longer than 40 characters');
        }
    }
}

<?php

namespace Domain\SomeSpecificApplication\CreateApp\UseCase;

use InvalidArgumentException;

class CreateAppParameter
{
    /**
     * @var string
     */
    public readonly string $name;

    /**
     * @var int
     */
    public readonly int $age;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        if (empty($input['name'])) {
            throw new InvalidArgumentException('Name is required');
        }

        if (empty($input['age']) && !is_int($input['age'])) {
            throw new InvalidArgumentException('Name is required');
        }

        $this->name = $input['name'];
        $this->age = $input['age'];
    }
}

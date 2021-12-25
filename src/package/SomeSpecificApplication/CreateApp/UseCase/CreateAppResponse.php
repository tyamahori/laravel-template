<?php

namespace Package\SomeSpecificApplication\CreateApp\UseCase;

use InvalidArgumentException;

class CreateAppResponse
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
     * @param array $output
     */
    public function __construct(array $output)
    {
        if (empty($output['name'])) {
            throw new InvalidArgumentException('Name is required');
        }

        if (empty($output['age']) && !is_int($output['age'])) {
            throw new InvalidArgumentException('Age is required');
        }

        $this->name = $output['name'];
        $this->age = $output['age'];
    }
}

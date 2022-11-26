<?php
declare(strict_types=1);

namespace Package\SomeSpecificApplication\CreateApp\Domain\Entity;

use Package\SomeSpecificApplication\CreateApp\Domain\ValueObject\Age;
use Package\SomeSpecificApplication\CreateApp\Domain\ValueObject\Name;

class LoginUserAccount
{
    /**
     * @param Name $name
     * @param Age $age
     */
    private function __construct(
        public readonly Name $name,
        public readonly Age $age
    ) {
    }

    /**
     * @param Name $name
     * @param Age $age
     * @return LoginUserAccount
     */
    public static function new(Name $name, Age $age): self
    {
        return new self($name, $age);
    }

    /**
     * @param Name $name
     * @return LoginUserAccount
     */
    public function updateName(Name $name): self
    {
        return new self($name, $this->age);
    }

    /**
     * @param Age $age
     * @return LoginUserAccount
     */
    public function updateAge(Age $age): self
    {
        return new self($this->name, $age);
    }
}

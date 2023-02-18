<?php
declare(strict_types=1);

namespace Package\SomeSpecificApplication\CreateApp\Adaptor;

interface CreateAppControllerInterface
{
    public function __invoke(): mixed;
}

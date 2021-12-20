<?php

namespace Package\SomeSpecificApplication\CreateApp\Domain\Repository;

use Package\SomeSpecificApplication\CreateApp\Domain\Entity\LoginUserAccount;

interface SampleRepositoryInterface
{
    /**
     * @param LoginUserAccount $loginUserAccount
     * @return void
     */
    public function auth(LoginUserAccount $loginUserAccount): void;
}

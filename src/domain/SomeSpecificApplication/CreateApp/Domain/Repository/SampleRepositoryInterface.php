<?php

namespace Domain\SomeSpecificApplication\CreateApp\Domain\Repository;

use Domain\SomeSpecificApplication\CreateApp\Domain\Entity\LoginUserAccount;

interface SampleRepositoryInterface
{
    /**
     * @param LoginUserAccount $loginUserAccount
     * @return void
     */
    public function auth(LoginUserAccount $loginUserAccount): void;
}

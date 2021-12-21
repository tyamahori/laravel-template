<?php

namespace Package\SomeSpecificApplication\CreateApp\Concrete\Infrastructre\Repository;

use Package\SomeSpecificApplication\CreateApp\Domain\Entity\LoginUserAccount;
use Package\SomeSpecificApplication\CreateApp\Domain\Repository\SampleRepositoryInterface;
use Psr\Log\LoggerInterface;

class AuthLoggerRepository implements SampleRepositoryInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * @param LoginUserAccount $loginUserAccount
     * @return void
     */
    public function auth(LoginUserAccount $loginUserAccount): void
    {
        $this->logger->info('login', [
            'message' => 'success!',
            'user' => [
                'name' => $loginUserAccount->name->name,
            ],
        ]);
    }
}

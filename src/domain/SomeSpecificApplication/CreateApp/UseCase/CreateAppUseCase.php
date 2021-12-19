<?php

namespace Domain\SomeSpecificApplication\CreateApp\UseCase;

use Domain\SomeSpecificApplication\CreateApp\Domain\Entity\LoginUserAccount;
use Domain\SomeSpecificApplication\CreateApp\Domain\Repository\SampleRepositoryInterface;
use Domain\SomeSpecificApplication\CreateApp\Domain\ValueObject\Age;
use Domain\SomeSpecificApplication\CreateApp\Domain\ValueObject\Name;

class CreateAppUseCase
{
    /**
     * @param SampleRepositoryInterface $sampleRepository
     */
    public function __construct(
        private SampleRepositoryInterface $sampleRepository
    ) {
    }

    /**
     * @param CreateAppParameter $parameter
     * @return CreateAppResponse
     */
    public function __invoke(CreateAppParameter $parameter): CreateAppResponse
    {
        $name = new Name($parameter->name);
        $age = new Age($parameter->age);

        $accountUser = LoginUserAccount::new($name, $age);

        $this->sampleRepository->auth($accountUser);

        return new CreateAppResponse([
            'name' => $accountUser->name->name,
            'age' => $accountUser->age->age,
        ]);
    }
}

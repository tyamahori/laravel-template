<?php

namespace Package\SomeSpecificApplication\CreateApp\Adaptor;

use Package\SomeSpecificApplication\CreateApp\UseCase\CreateAppResponse;

class Responder
{
    /**
     * @param CreateAppResponse $response
     * @return array
     */
    public function toArray(CreateAppResponse $response): array
    {
        return [
            'content' => [
                'message' => 'Successfully created user!',
                'userProfile' => [
                    'name' => $response->name,
                    'age' => $response->name,
                ],
            ],
        ];
    }
}

<?php

namespace Package\SomeSpecificApplication\CreateApp\Adaptor;

interface CreateAppControllerInterface
{
    /**
     * @param Responder $responder
     */
    public function __invoke(Responder $responder);
}

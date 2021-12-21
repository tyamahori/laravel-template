<?php

namespace Package\SomeSpecificApplication\CreateApp\Concrete\Adaptor;

use App\Http\Controllers\Controller;
use Package\SomeSpecificApplication\CreateApp\Adaptor\CreateAppControllerInterface;
use Package\SomeSpecificApplication\CreateApp\Adaptor\Responder;
use Package\SomeSpecificApplication\CreateApp\UseCase\CreateAppParameter;
use Package\SomeSpecificApplication\CreateApp\UseCase\CreateAppUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAppController extends Controller implements CreateAppControllerInterface
{
    /**
     * @param Request $request
     * @param CreateAppUseCase $createAppUseCase
     */
    public function __construct(
        private Request $request,
        private CreateAppUseCase $createAppUseCase,
    ) {
        $this->validate($this->request, [
            'user_name' => ['required', 'string', 'max:255'],
            'user_age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);
    }

    /**
     * @param Responder $responder
     * @return JsonResponse
     */
    public function __invoke(
        Responder $responder
    ): JsonResponse {
        $parameter = new CreateAppParameter([
            'name' => $this->request->input('user_name'),
            'age' => $this->request->input('user_age'),
        ]);

        $response = $this->createAppUseCase->__invoke($parameter);

        return response()->json($responder->toArray($response));
    }
}

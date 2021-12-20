<?php

namespace Package\SomeSpecificApplication\CreateApp\Infrastructure\Controller;

use App\Http\Controllers\Controller;
use Package\SomeSpecificApplication\CreateApp\Controller\CreateAppControllerInterface;
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
        private CreateAppUseCase $createAppUseCase
    ) {
    }

    /**
     * @param
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $this->validate($this->request, [
            'user_name' => ['required', 'string', 'max:255'],
            'user_age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);

        $parameter = new CreateAppParameter([
            'name' => $this->request->input('user_name'),
            'age' => $this->request->input('user_age'),
        ]);

        $response = $this->createAppUseCase->__invoke($parameter);

        return response()->json([
            'message' => 'Successfully created user!',
            'userProfile' => [
                'name' => $response->name,
                'age' => $response->age,
            ],
        ]);
    }
}

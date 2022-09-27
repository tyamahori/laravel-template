<?php

namespace Package\SomeSpecificApplication\CreateApp\Concrete\Adaptor;

use App\Http\Controllers\Controller;
use Package\SomeSpecificApplication\CreateApp\Adaptor\CreateAppControllerInterface;
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
        private readonly Request $request,
        private readonly CreateAppUseCase $createAppUseCase,
    ) {
        $this->middleware(static function (Request $request) {
            $request->validate([
                'user_name' => ['required', 'string', 'max:255'],
                'user_age' => ['required', 'integer', 'min:0', 'max:40'],
            ]);
        });
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $parameter = new CreateAppParameter([
            'name' => $this->request->input('user_name'),
            'age' => $this->request->input('user_age'),
        ]);

        $response = $this->createAppUseCase->__invoke($parameter);

        return new JsonResponse([
            'content' => [
                'message' => 'Successfully created user!',
                'userProfile' => [
                    'name' => $response->name,
                    'age' => $response->age,
                ],
            ],
        ]);
    }
}

<?php

namespace Domain\SomeSpecificApplication\CreateApp\Controller;

use App\Http\Controllers\Controller;
use Domain\SomeSpecificApplication\CreateApp\UseCase\CreateAppParameter;
use Domain\SomeSpecificApplication\CreateApp\UseCase\CreateAppUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAppController extends Controller
{
    /**
     * @param Request $request
     * @param CreateAppUseCase $appUseCase
     * @return JsonResponse
     */
    public function __invoke(
        Request $request,
        CreateAppUseCase $appUseCase
    ): JsonResponse {

        $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'user_age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);

        $parameter = new CreateAppParameter([
            'name' => $request->input('user_name'),
            'age' => $request->input('user_age'),
        ]);

        $response = $appUseCase($parameter);

        return response()->json([
            'message' => 'Successfully created user!',
            'userProfile' => [
                'name' => $response->name,
                'age' => $response->age,
            ],
        ]);
    }
}

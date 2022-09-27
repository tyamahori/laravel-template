<?php

namespace Package\ScenariotestSampleApplication\ScenarioSample\Adaptor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RunnSampleController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'user_age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);

        return new JsonResponse([
            'userName' => $request->input('user_name'),
            'userAge' => $request->input('user_age'),
        ]);
    }
}

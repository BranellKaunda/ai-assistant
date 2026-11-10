<?php

namespace App\Http\Controllers;

use App\Ai\Agents\PersonalAssistant;
use App\Http\Requests\AskAssistantRequest;
use Illuminate\Http\JsonResponse;

class AssistantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AskAssistantRequest $request): JsonResponse
    {
        $response = PersonalAssistant::make()->prompt($request->validated('question'));
        // prompt($request->validated('question')) is from Promptable trait in PersonalAssistant class

        return response()->json([
            'answer' => $response->text,
        ]);
    }
}

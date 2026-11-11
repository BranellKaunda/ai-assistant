<?php

namespace App\Http\Controllers;

use App\Ai\Agents\PersonalAssistant;
use App\Http\Requests\AskAssistantRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use League\CommonMark\CommonMarkConverter;

class AssistantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AskAssistantRequest $request): JsonResponse
    {
        $question = $request->validated('question');

        // Store the question in the database
        Question::create([
            'question' => $question,
        ]);
        
        $response = PersonalAssistant::make()->prompt($question);
        // prompt($question) is from Promptable trait in PersonalAssistant class

        $html= new CommonMarkConverter();
        // Convert the response text to HTML using CommonMarkConverter

        return response()->json([
            'answer' => $html->convert($response->text)->getContent(),
        ]);
    }
}

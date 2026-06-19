<?php

namespace App\Http\Controllers;

use App\Services\GroqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class AiAssistantController extends Controller
{
    public function index(): View
    {
        return view('ai-assistant');
    }

    public function ask(Request $request, GroqService $groq): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $answer = $groq->chat($validated['message']);

            return response()->json([
                'answer' => $answer,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'AI Assistant belum bisa merespons. Coba beberapa saat lagi.',
            ], 500);
        }
    }
}
<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TriviaService
{
    protected $apiUrl = 'https://opentdb.com/api.php';

    public function fetchQuestions(
        int $amount = 10,
        string $category = null,
        string $difficulty = null,
        string $type = null
    ) {
        $params = [
            'amount' => $amount,
        ];

        if ($category) {
            $params['category'] = $category;
        }

        if ($difficulty) {
            $params['difficulty'] = $difficulty;
        }

        if ($type) {
            $params['type'] = $type;
        }

        try {
            $response = Http::get($this->apiUrl, $params);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['response_code']) && $responseData['response_code'] === 0) {
                    if (isset($responseData['results']) && is_array($responseData['results'])) {
                        return $responseData['results'];
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error
        }

        return [];
    }

    public function saveQuestions(array $questions)
    {
        $savedQuestions = [];

        foreach ($questions as $questionData) {
            try {
                // Check if the question already exists to avoid duplicates
                $existingQuestion = Question::where('question', $questionData['question'])->first();

                if (!$existingQuestion) {
                    $newQuestion = Question::create([
                        'question' => $questionData['question'],
                        'category' => $questionData['category'],
                        'difficulty' => $questionData['difficulty'],
                        'type' => $questionData['type'],
                        'correct_answer' => $questionData['correct_answer'],
                        'incorrect_answers' => $questionData['incorrect_answers'],
                    ]);

                    $savedQuestions[] = $newQuestion;
                } else {
                    $savedQuestions[] = $existingQuestion;
                }
            } catch (\Exception $e) {
                // Log error
            }
        }

        return $savedQuestions;
    }

    public function getQuestions(
        int $amount = 10,
        string $category = null,
        string $difficulty = null,
        string $type = null
    ) {
        $questions = $this->fetchQuestions($amount, $category, $difficulty, $type);

        if (empty($questions)) {
            return [];
        }

        return $this->saveQuestions($questions);
    }
}

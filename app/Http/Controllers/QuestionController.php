<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserResponse;
use App\Services\TriviaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $triviaService;

    public function __construct(TriviaService $triviaService)
    {
        $this->triviaService = $triviaService;
    }

    /**
     * Show the question categories
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = [
            '9' => 'General Knowledge',
            '10' => 'Entertainment: Books',
            '11' => 'Entertainment: Film',
            '12' => 'Entertainment: Music',
            '14' => 'Entertainment: Television',
            '15' => 'Entertainment: Video Games',
            '17' => 'Science & Nature',
            '18' => 'Science: Computers',
            '19' => 'Science: Mathematics',
            '21' => 'Sports',
            '22' => 'Geography',
            '23' => 'History',
            '24' => 'Politics',
            '25' => 'Art',
            '27' => 'Animals',
            '28' => 'Vehicles',
        ];

        return view('questions.index', compact('categories'));
    }

    /**
     * Show a trivia question
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $category = $request->input('category');
        $difficulty = $request->input('difficulty');

        try {
            // Fetch a new question
            $questions = $this->triviaService->getQuestions(1, $category, $difficulty);

            if (empty($questions)) {
                return redirect()->route('questions.index')
                    ->with('error', 'Unable to fetch questions. Please try again.');
            }

            $question = $questions[0];

            // Get all possible answers
            $answers = array_merge([$question->correct_answer], $question->incorrect_answers);
            // Shuffle the answers
            shuffle($answers);

            return view('questions.show', compact('question', 'answers'));
        } catch (\Exception $e) {
            \Log::error('Error in question show page', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('questions.index')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Submit an answer to a question
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function answer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);

        $question = Question::findOrFail($request->question_id);
        $isCorrect = $request->answer === $question->correct_answer;

        // Save the user's response
        UserResponse::create([
            'user_id' => Auth::id(),
            'question_id' => $question->id,
            'selected_answer' => $request->answer,
            'is_correct' => $isCorrect,
            'time_taken' => $request->time_taken,
        ]);

        return redirect()->route('questions.result', ['question' => $question->id])
            ->with('is_correct', $isCorrect)
            ->with('selected_answer', $request->answer);
    }

    /**
     * Show the result of a question
     *
     * @param Question $question
     * @return \Illuminate\View\View
     */
    public function result(Question $question)
    {
        $isCorrect = session('is_correct');
        $selectedAnswer = session('selected_answer');

        if ($isCorrect === null || $selectedAnswer === null) {
            return redirect()->route('questions.show');
        }

        return view('questions.result', compact('question', 'isCorrect', 'selectedAnswer'));
    }
}

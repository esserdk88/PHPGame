<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'question' => 'What is the capital of France?',
                'category' => 'Geography',
                'difficulty' => 'easy',
                'type' => 'multiple',
                'correct_answer' => 'Paris',
                'incorrect_answers' => ['London', 'Berlin', 'Madrid'],
            ],
            [
                'question' => 'Who painted the Mona Lisa?',
                'category' => 'Art',
                'difficulty' => 'easy',
                'type' => 'multiple',
                'correct_answer' => 'Leonardo da Vinci',
                'incorrect_answers' => ['Pablo Picasso', 'Vincent van Gogh', 'Michelangelo'],
            ],
            [
                'question' => 'In which year did World War II end?',
                'category' => 'History',
                'difficulty' => 'medium',
                'type' => 'multiple',
                'correct_answer' => '1945',
                'incorrect_answers' => ['1939', '1942', '1950'],
            ],
            [
                'question' => 'What is the largest planet in our solar system?',
                'category' => 'Science & Nature',
                'difficulty' => 'easy',
                'type' => 'multiple',
                'correct_answer' => 'Jupiter',
                'incorrect_answers' => ['Saturn', 'Neptune', 'Earth'],
            ],
            [
                'question' => 'Which programming language was created by Bjarne Stroustrup?',
                'category' => 'Science: Computers',
                'difficulty' => 'medium',
                'type' => 'multiple',
                'correct_answer' => 'C++',
                'incorrect_answers' => ['Java', 'Python', 'C#'],
            ],
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }
    }
}

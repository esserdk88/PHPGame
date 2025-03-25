<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $question->category }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm ml-2">
                            {{ ucfirst($question->difficulty) }}
                        </span>
                    </div>

                    <h3 class="text-xl font-semibold mb-6">{{ $question->question }}</h3>

                    <form action="{{ route('questions.answer') }}" method="POST">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <input type="hidden" name="time_taken" id="time_taken" value="0">

                        <div class="space-y-3">
                            @foreach($answers as $answer)
                                <div class="flex items-center">
                                    <input type="radio" id="answer_{{ $loop->index }}" name="answer" value="{{ $answer }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="answer_{{ $loop->index }}" class="ml-3 block text-gray-700">
                                        {{ $answer }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Answer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple timer to track how long the user takes to answer
        document.addEventListener('DOMContentLoaded', function() {
            const startTime = Date.now();
            const timeInput = document.getElementById('time_taken');

            // Update the hidden time input every second
            setInterval(function() {
                const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
                timeInput.value = elapsedSeconds;
            }, 1000);

            // Also set it on form submission
            document.querySelector('form').addEventListener('submit', function() {
                const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
                timeInput.value = elapsedSeconds;
            });
        });
    </script>
</x-app-layout>

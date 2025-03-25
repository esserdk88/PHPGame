<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your Stats</h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Questions Answered</h4>
                            <p class="text-2xl">{{ $stats['total_questions_answered'] }}</p>
                        </div>

                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Correct Answers</h4>
                            <p class="text-2xl">{{ $stats['correct_answers'] }} ({{ $stats['accuracy'] }}%)</p>
                        </div>

                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Pictures Uploaded</h4>
                            <p class="text-2xl">{{ $stats['total_pictures_uploaded'] }}</p>
                        </div>

                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Ratings Given</h4>
                            <p class="text-2xl">{{ $stats['total_ratings_given'] }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Recent Questions -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">Recent Questions</h3>

                            @if($recentResponses->isEmpty())
                                <p class="text-gray-500">You haven't answered any questions yet.</p>
                            @else
                                <div class="border rounded-lg overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Question</th>
                                            <th class="px-4 py-2 text-left">Result</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recentResponses as $response)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">
                                                    {{ \Illuminate\Support\Str::limit($response->question->question, 50) }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if($response->is_correct)
                                                        <span class="text-green-600">Correct</span>
                                                    @else
                                                        <span class="text-red-600">Incorrect</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('questions.index') }}" class="text-blue-600 hover:underline">
                                        Answer more questions →
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Recent Ratings -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">Recent Ratings</h3>

                            @if($recentRatings->isEmpty())
                                <p class="text-gray-500">You haven't rated any pictures yet.</p>
                            @else
                                <div class="border rounded-lg overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Picture</th>
                                            <th class="px-4 py-2 text-left">Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recentRatings as $rating)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">
                                                    {{ \Illuminate\Support\Str::limit($rating->picture->title, 50) }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    {{ $rating->score }}/5
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('pictures.index') }}" class="text-blue-600 hover:underline">
                                        Rate more pictures →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('questions.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Take a Quiz
                            </a>
                            <a href="{{ route('pictures.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-700 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Upload Picture
                            </a>
                            <a href="{{ route('pictures.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-700 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Rate Pictures
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

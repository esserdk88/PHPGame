<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $picture->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 md:pr-4 mb-4 md:mb-0">
                            <img src="{{ asset('storage/' . $picture->image_path) }}" alt="{{ $picture->title }}" class="w-full rounded">

                            <div class="mt-4 flex justify-between items-center">
                                <div>
                                    <span class="text-sm text-gray-500">Uploaded by {{ $picture->user->name }}</span>
                                    <span class="text-sm text-gray-500 ml-4">{{ $picture->created_at->diffForHumans() }}</span>
                                </div>

                                @can('delete', $picture)
                                    <form action="{{ route('pictures.destroy', $picture) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this picture?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="md:w-1/2 md:pl-4">
                            <h3 class="text-xl font-semibold mb-4">Rate This Picture</h3>

                            <form action="{{ route('ratings.store', $picture) }}" method="POST" class="mb-6">
                                @csrf

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div class="mr-2">
                                                <input type="radio" id="score_{{ $i }}" name="score" value="{{ $i }}" {{ $userRating && $userRating->score == $i ? 'checked' : '' }} class="hidden peer">
                                                <label for="score_{{ $i }}" class="cursor-pointer block text-center w-10 h-10 flex items-center justify-center rounded-full border {{ $userRating && $userRating->score == $i ? 'bg-yellow-500 text-white border-yellow-500' : 'border-gray-300 hover:bg-yellow-100' }} peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500">
                                                    {{ $i }}
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                    @error('score')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment (Optional)</label>
                                    <textarea id="comment" name="comment" rows="3" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">{{ $userRating ? $userRating->comment : '' }}</textarea>
                                    @error('comment')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ $userRating ? 'Update Rating' : 'Submit Rating' }}
                                    </button>
                                </div>
                            </form>

                            <div class="border-t pt-4">
                                <h4 class="font-medium mb-3">Ratings and Comments ({{ $picture->ratings->count() }})</h4>

                                @if($picture->ratings->isEmpty())
                                    <p class="text-gray-500">No ratings yet. Be the first to rate!</p>
                                @else
                                    <div class="space-y-4">
                                        @foreach($picture->ratings as $rating)
                                            <div class="border-b pb-3">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="flex items-center">
                                                            <div class="font-medium">{{ $rating->user->name }}</div>
                                                            <div class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                                                                {{ $rating->score }}/5
                                                            </div>
                                                        </div>
                                                        <div class="text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</div>
                                                    </div>

                                                    @can('delete', $rating)
                                                        <form action="{{ route('ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rating?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                                                        </form>
                                                    @endcan
                                                </div>

                                                @if($rating->comment)
                                                    <div class="mt-2 text-gray-700">
                                                        {{ $rating->comment }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('pictures.index') }}" class="text-blue-600 hover:underline">
                            &larr; Back to all pictures
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funny Pictures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Browse Pictures</h3>
                <a href="{{ route('pictures.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700">
                    Upload Picture
                </a>
            </div>

            @if($pictures->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="text-gray-500">No pictures have been uploaded yet. Be the first to upload!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($pictures as $picture)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <a href="{{ route('pictures.show', $picture) }}">
                                <img src="{{ asset('storage/' . $picture->image_path) }}" alt="{{ $picture->title }}" class="w-full h-48 object-cover">
                            </a>
                            <div class="p-4">
                                <h4 class="font-medium truncate">{{ $picture->title }}</h4>
                                <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                                    <div>
                                        By {{ $picture->user->name }}
                                    </div>
                                    <div class="flex items-center">
                                        <!-- Star icon -->
                                        <svg class="h-4 w-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="ml-1">
                                            {{ number_format($picture->ratings->avg('score') ?? 0, 1) }}
                                            ({{ $picture->ratings_count }})
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('pictures.show', $picture) }}" class="text-blue-600 hover:underline text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $pictures->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the pictures
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pictures = Picture::with(['user', 'ratings'])
            ->withCount('ratings')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pictures.index', compact('pictures'));
    }

    /**
     * Show the form for creating a new picture
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pictures.create');
    }

    /**
     * Store a newly created picture in storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048', // 2MB max
            'category' => 'nullable|string|max:255',
        ]);

        // Store the uploaded image
        $path = $request->file('image')->store('pictures', 'public');

        // Create the picture record
        Picture::create([
            'title' => $request->title,
            'image_path' => $path,
            'user_id' => Auth::id(),
            'category' => $request->category,
        ]);

        return redirect()->route('pictures.index')
            ->with('success', 'Picture uploaded successfully!');
    }

    /**
     * Display the specified picture
     *
     * @param \App\Models\Picture $picture
     * @return \Illuminate\View\View
     */
    public function show(Picture $picture)
    {
        $picture->load(['user', 'ratings.user']);

        // Check if the current user has already rated this picture
        $userRating = null;
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('picture_id', $picture->id)
                ->first();
        }

        return view('pictures.show', compact('picture', 'userRating'));
    }

    /**
     * Remove the specified picture from storage
     *
     * @param \App\Models\Picture $picture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Picture $picture)
    {
        // Ensure the user can delete this picture
        $this->authorize('delete', $picture);

        // Delete the image file
        Storage::disk('public')->delete($picture->image_path);

        // Delete the picture record (ratings will be deleted by cascade)
        $picture->delete();

        return redirect()->route('pictures.index')
            ->with('success', 'Picture deleted successfully!');
    }
}

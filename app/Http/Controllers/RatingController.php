<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a new rating
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Picture $picture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Picture $picture)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if the user has already rated this picture
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('picture_id', $picture->id)
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update([
                'score' => $request->score,
                'comment' => $request->comment,
            ]);

            $message = 'Rating updated successfully!';
        } else {
            // Create new rating
            Rating::create([
                'user_id' => Auth::id(),
                'picture_id' => $picture->id,
                'score' => $request->score,
                'comment' => $request->comment,
            ]);

            $message = 'Rating added successfully!';
        }

        return redirect()->route('pictures.show', $picture)
            ->with('success', $message);
    }

    /**
     * Delete a rating
     *
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Rating $rating)
    {
        // Ensure the user can delete this rating
        $this->authorize('delete', $rating);

        $picture = $rating->picture;
        $rating->delete();

        return redirect()->route('pictures.show', $picture)
            ->with('success', 'Rating deleted successfully!');
    }
}

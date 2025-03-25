<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Question;
use App\Models\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_questions_answered' => UserResponse::where('user_id', $user->id)->count(),
            'correct_answers' => UserResponse::where('user_id', $user->id)->where('is_correct', true)->count(),
            'total_pictures_uploaded' => Picture::where('user_id', $user->id)->count(),
            'total_ratings_given' => $user->ratings()->count(),
        ];

        // Calculate accuracy percentage
        $stats['accuracy'] = $stats['total_questions_answered'] > 0
            ? round(($stats['correct_answers'] / $stats['total_questions_answered']) * 100, 1)
            : 0;

        // Get recent questions answered
        $recentResponses = UserResponse::where('user_id', $user->id)
            ->with('question')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent pictures rated
        $recentRatings = $user->ratings()
            ->with('picture')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentResponses', 'recentRatings'));
    }
}

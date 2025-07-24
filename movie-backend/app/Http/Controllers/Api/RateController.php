<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;

class RateController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        // Only one rating per user per movie
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $existing = Rating::where('user_id', $user->id)
                          ->where('movie_id', $data['movie_id'])
                          ->first();

        if ($existing) {
            $existing->update(['rating' => $data['rating']]);
            return $existing;
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $data['user_id'] = $user->id;

        return Rating::create($data);
    }

    public function index($movieId)
    {
        return Rating::where('movie_id', $movieId)->with('user')->get();
    }
}

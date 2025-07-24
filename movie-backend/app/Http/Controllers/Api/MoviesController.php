<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MoviesController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return Movie::with(['user'])->get();
    }

    public function show($id)
    {
        return Movie::with(['comments', 'ratings'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail_url' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id(); // Admin

        return Movie::create($data);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $this->authorize('update', $movie);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail_url' => 'nullable|string',
        ]);

        $movie->update($data);

        return $movie;
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $this->authorize('delete', $movie);
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}


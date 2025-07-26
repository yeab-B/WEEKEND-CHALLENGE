<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\MoviesPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MoviesController extends Controller
{
    protected $MoviesPolicy;
    public function __construct()
    {
    
        // $this->MoviesPolicy = 'App\Policies\MoviesPolicy';
        $this->MoviesPolicy = \App\Policies\MoviePolicy::class;

    }
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
        $policy = new $this->MoviesPolicy;
        if (!$policy->create(Auth::user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
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
        $policy = new $this->MoviesPolicy;
        if (!$policy->update(Auth::user(), $movie)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

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
        $policy = new $this->MoviesPolicy;
        if (!$policy->delete(Auth::user(), $movie)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}


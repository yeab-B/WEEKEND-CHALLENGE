<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'content' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        return Comment::create($data);
    }

    public function index($movieId)
    {
        return Comment::where('movie_id', $movieId)->with('user')->get();
    }
}

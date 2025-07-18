<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\GenericPolicy;

class ArticleController extends Controller
{
  protected $genericPolicy;

    public function __construct(GenericPolicy $genericPolicy)
    {
        $this->genericPolicy = $genericPolicy;
    }

    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('user.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('user.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('user.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('user.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update($request->only('title', 'content'));

        return redirect()->route('articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('user.articles.index')->with('success', 'Article deleted.');
    }

    public function approve(Article $article)
    {
        $article->approved = true;
        $article->save();

        return redirect()->route('user.articles.index')->with('success', 'Article approved.');
    }
}

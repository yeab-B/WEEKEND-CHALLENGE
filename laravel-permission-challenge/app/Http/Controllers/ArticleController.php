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
        if (!$this->genericPolicy->view(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }

        $articles = Article::latest()->paginate(10);
        return view('user.articles.index', compact('articles'));
    }

    public function create()
    {
        if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.articles.create');
    }

    public function store(Request $request)
    {
        if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
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
          if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.articles.partials.show', compact('article'));
    }

    public function edit(Article $article)
    { 
         if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.articles.partials.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    { 
         if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update($request->only('title', 'content'));

        return redirect()->route('articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    { 
         if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted.');
    }

    public function approve(Article $article)
    { 
        if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }
        $article->approved = true;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article approved.');
    }
}

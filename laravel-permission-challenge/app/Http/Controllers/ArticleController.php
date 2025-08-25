<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Language;
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
        $languages = Language::all();
        return view('user.articles.index', compact('articles', 'languages'));
    }

    public function create()
    {
        if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }

        $languages = Language::all();
        return view('user.articles.create', compact('languages'));
    }

    public function store(Request $request)
    {
        if (!$this->genericPolicy->create(Auth::user(), new Article())) {
            abort(403, 'Unauthorized action.');
        }

       $request->validate([
          'lang_id' => 'required|exists:languages,id',
    'title'   => 'required|string|max:255',
    'content' => 'required|string',
  
]);

Article::create([
    'user_id' => Auth::id(),
     'lang_id' => $request->lang_id,
    'title'   => $request->title,
    'content' => $request->content,
   
]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        if (!$this->genericPolicy->view(Auth::user(), $article)) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.articles.partials.show', compact('article'));
    }

    public function edit(Article $article)
    { 
        if (!$this->genericPolicy->update(Auth::user(), $article)) {
            abort(403, 'Unauthorized action.');
        }

        $languages = Language::all();
        return view('user.articles.partials.form', compact('article', 'languages'));
    }

    public function update(Request $request, Article $article)
    { 
        if (!$this->genericPolicy->update(Auth::user(), $article)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
             'lang_id' => 'required|exists:languages,id',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
           
        ]);

        $article->update($request->only('title', 'content', 'lang_id'));

        return redirect()->route('articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    { 
        if (!$this->genericPolicy->delete(Auth::user(), $article)) {
            abort(403, 'Unauthorized action.');
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted.');
    }

    public function approve(Article $article)
    { 
        if (!$this->genericPolicy->approve(Auth::user(), $article)) {
            abort(403, 'Unauthorized action.');
        }

        $article->approved = true;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article approved.');
    }
}

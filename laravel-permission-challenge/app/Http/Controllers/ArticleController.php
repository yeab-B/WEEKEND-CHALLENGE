<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $languages = Language::all();
        return view('user.articles.index', compact('articles', 'languages'));
    }

    public function create()
    {
      

        $languages = Language::all();
        return view('user.articles.create', compact('languages'));
    }

    public function store(Request $request)
    {
        

        $request->validate([
            'lang_id' => 'required|exists:languages,id',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = Article::create([
            'user_id' => Auth::id(),
            'lang_id' => $request->lang_id,
            'title'   => $request->title,
            'content' => $request->content,

        ]);
        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')
                ->toMediaCollection('images');
            Log::info('Image uploaded successfully: ' . $request->file('image')->getClientOriginalName());
        } else {
            Log::info('No image uploaded for article: ' . $article->id);
        }

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        
        return view('user.articles.partials.show', compact('article'));
    }

    public function edit(Article $article)
    {
       

        $languages = Language::all();
        return view('user.articles.partials.form', compact('article', 'languages'));
    }

    public function update(Request $request, Article $article)
    {
       

        $request->validate([
            'lang_id' => 'required|exists:languages,id',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $article->clearMediaCollection('images'); // remove old image
            $article->addMediaFromRequest('image')->toMediaCollection('images');
        }

        $article->update($request->only('title', 'content', 'lang_id'));

        return redirect()->route('articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
      

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted.');
    }

    // public function approve(Article $article)
    // {
    //     if (!$this->genericPolicy->approve(Auth::user(), $article)) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $article->approved = true;
    //     $article->save();

    //     return redirect()->route('articles.index')->with('success', 'Article approved.');
    // }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{

    public function __construct(){
        $this->middleware('can:articles.index')->only('index');
        $this->middleware('can:articles.create')->only('create', 'store');
        $this->middleware('can:articles.edit')->only('edit', 'update');
        $this->middleware('can:articles.destroy')->only('destroy');
    }

    public function index(){
        $user = Auth::user();

        $articles = Article::where('user_id', $user->id)->orderBy('id', 'desc')->simplePaginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create(){
        $categories = Category::where('status', 1)->get();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(ArticleRequest $request){
        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        $article = $request->all();

        if($request->hasFile('image')){
            $article['image'] = $request->file('image')->store('articles');
        }

        Article::create($article);

        return redirect()->route('articles.index')->with('success', 'Article created successfully');
    }

    public function show(Article $article){
        $this->authorize('published', $article);
        $comments = $article->comment()->simplePaginate(5);
        return view('subscriber.articles.show', compact('article', 'comments'));
    }

    public function edit(Article $article){
        $this->authorize('view', $article);
        $categories = Category::where('status', 1)->get();
        return view('admin.articles.edit', compact('categories', 'article'));
    }

    public function update(ArticleRequest $request, Article $article){
        $this->authorize('update', $article);
        $article->update($request->all());
        if($request->hasFile('image')){
            File::delete(public_path('storage/'.$article->image));
            $article['image'] = $request->file('image')->store('articles');
        }

        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'status' => $request->status
        ]);

        return redirect()->route('articles.index')->with('success-update', 'Article updated successfully');
    }

    public function destroy(Article $article){
        $this->authorize('delete', $article);
        if ($article->image) {
            File::delete(public_path('storage/'.$article->image));
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success-delete', 'Article deleted successfully');
    }
}

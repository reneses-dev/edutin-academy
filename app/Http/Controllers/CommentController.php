<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('can:comments.index')->only('index');
        $this->middleware('can:comments.destroy')->only('destroy');
    }

    //Display a listing of the resource.
    public function index()
    {
        $comments = DB::table('comments')
                        ->join('articles', 'comments.article_id', '=', 'articles.id')
                        ->join('users', 'comments.user_id', '=', 'users.id')
                        ->select('comments.id','comments.value', 'comments.description', 'articles.title', 'users.name')
                        ->where('articles.user_id', Auth::user()->id)
                        ->orderBy('articles.id', 'desc')->get();
        
        return view('admin.comments.index', compact('comments'));
    }

    
    //Store a newly created resource in storage.
    public function store(CommentRequest $request)
    {
        $result = Comment::where('user_id', Auth::user()->id)
                        ->where('article_id', $request->article_id)->exists();
        
        $article = Article::select('status', 'slug')->find($request->article_id);

        if(!$result && $article->status == 1){
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'article_id' => $request->article_id
            ]);
            
            return redirect()->action([ArticleController::class, 'show'], [$article->slug]);

        } else{

            return redirect()->action([ArticleController::class, 'show'], [$article->slug])
                             ->with('success-error', 'You have already commented on this article!');

        }
    }

    //Remove the specified resource from storage.
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->route('comments.index')->with('success-delete', 'Comment deleted successfully!');
    }
}
